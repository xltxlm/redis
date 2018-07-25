<?php
/**
 * Created by PhpStorm.
 * User: xialintai
 * Date: 2016/12/26
 * Time: 17:16.
 */

namespace xltxlm\redis;

use Redis;
use xltxlm\redis\Config\RedisConfig;

final class RedisClient
{
    /** @var RedisConfig */
    protected $redisConfig;
    private static $client = [];

    /**
     * @return RedisConfig
     */
    public function getRedisConfig(): RedisConfig
    {
        return $this->redisConfig;
    }

    /**
     * @param RedisConfig $redisConfig
     *
     * @return Redis
     */
    public function setRedisConfig(RedisConfig $redisConfig): \Redis
    {
        return $redisConfig->__invoke();
    }
}
