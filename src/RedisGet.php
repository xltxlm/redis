<?php
/**
 * Created by PhpStorm.
 * User: xialintai
 * Date: 2017/2/15
 * Time: 18:16
 */

namespace xltxlm\redis;

use Predis\Client;
use xltxlm\redis\Config\RedisConfig;

/**
 * 获取redis的key值,并且在一个进程内,相同key不再请求
 * Class RedisGet
 * @package xltxlm\redis
 */
class RedisGet extends RedisClient
{
    protected static $keys = [];
    /** @var Client */
    protected $client;

    public function setRedisConfig(RedisConfig $redisConfig): Client
    {
        return $this->client = parent::setRedisConfig($redisConfig);
    }

    public function get($key)
    {
        if (empty(self::$keys[$key])) {
            self::$keys[$key] = $this->client->get($key);
        }
        return self::$keys[$key];
    }

    public function set($key, $value)
    {
        $this->client->set($key, $value);
        self::$keys[$key] = $value;
    }
}