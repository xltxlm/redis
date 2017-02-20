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
use xltxlm\redis\Logger\RedisRunLog;

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
            (new RedisRunLog($this))
                ->setMethod(__METHOD__)
                ->__invoke();
            self::$keys[$key] = $this->client->get($key);
        }

        return self::$keys[$key];
    }

    public function set($key, $value)
    {
        $this->client->set($key, $value);
        (new RedisRunLog($this))
            ->setMethod(__METHOD__)
            ->__invoke();
        self::$keys[$key] = $value;
    }
}
