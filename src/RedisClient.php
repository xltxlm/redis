<?php
/**
 * Created by PhpStorm.
 * User: xialintai
 * Date: 2016/12/26
 * Time: 17:16.
 */

namespace xltxlm\redis;

use Predis\Client;
use xltxlm\redis\Config\RedisConfig;

final class RedisClient
{
    /** @var RedisConfig */
    protected $redisConfig;

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
     * @return Client
     */
    public function setRedisConfig(RedisConfig $redisConfig): Client
    {
        // Parameters passed using a named array:
        $client = new Client(
            [
                'scheme' => 'tcp',
                'host' => $redisConfig->getHost(),
                'port' => $redisConfig->getPort(),
            ]
        );

        return $client;
    }
}
