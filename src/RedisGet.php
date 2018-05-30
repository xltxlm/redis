<?php
/**
 * Created by PhpStorm.
 * User: xialintai
 * Date: 2017/2/15
 * Time: 18:16.
 */

namespace xltxlm\redis;

use xltxlm\redis\Config\RedisConfig;
use xltxlm\logger\Operation\Action\RedisRunLog;

/**
 * 获取redis的key值,并且在一个进程内,相同key不再请求
 * Class RedisGet.
 */
class RedisGet
{
    protected static $keys = [];
    /** @var \Redis */
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

    /**
     * @return \Redis
     */
    public function getClient(): \Redis
    {
        return $this->client;
    }

    /**
     * @param \Redis $client
     * @return RedisGet
     */
    public function setClient(\Redis $client): RedisGet
    {
        $this->client = $client;
        return $this;
    }


    public function get($key)
    {
        if (empty(self::$keys[$key])) {
            $redisRunLog = new RedisRunLog($this);
            self::$keys[$key] = $this->client->get($key);
            $redisRunLog
                ->setMethod(__METHOD__)
                ->__invoke();
        }

        return self::$keys[$key];
    }

    public function set($key, $value)
    {
        $redisRunLog = new RedisRunLog($this);
        $this->client->set($key, $value);
        self::$keys[$key] = $value;
        $redisRunLog
            ->setMethod(__METHOD__)
            ->__invoke();
    }
}
