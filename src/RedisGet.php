<?php
/**
 * Created by PhpStorm.
 * User: xialintai
 * Date: 2017/2/15
 * Time: 18:16.
 */

namespace xltxlm\redis;

use Predis\Client;
use xltxlm\redis\Config\RedisConfig;
use xltxlm\logger\Operation\Action\RedisRunLog;

/**
 * 获取redis的key值,并且在一个进程内,相同key不再请求
 * Class RedisGet.
 */
class RedisGet
{
    protected static $keys = [];
    /** @var Client */
    protected $client;

    /** @var RedisConfig */
    protected $redisConfig;

    /**
     * @param RedisConfig $redisConfig
     *
     * @return RedisGet
     */
    public function setRedisConfig(RedisConfig $redisConfig)
    {
        $this->client = (new RedisClient())
            ->setRedisConfig($redisConfig);

        return $this;
    }

    public function get($key)
    {
        if (empty(self::$keys[$key])) {
            $start = microtime(true);
            self::$keys[$key] = $this->client->get($key);
            $time = sprintf('%.4f', microtime(true) - $start);
            (new RedisRunLog($this))
                ->setRunTime($time)
                ->setMethod(__METHOD__)
                ->__invoke();
        }

        return self::$keys[$key];
    }

    public function set($key, $value)
    {
        $start = microtime(true);
        $this->client->set($key, $value);
        self::$keys[$key] = $value;
        $time = sprintf('%.4f', microtime(true) - $start);
        (new RedisRunLog($this))
            ->setRunTime($time)
            ->setMethod(__METHOD__)
            ->__invoke();
    }
}
