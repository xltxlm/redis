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
use xltxlm\redis\Logger\RedisConnectLog;

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
     * @return Client
     */
    public function setRedisConfig(RedisConfig $redisConfig): Client
    {
        // Parameters passed using a named array:
        $config = [
            'scheme' => 'tcp',
            'host' => $redisConfig->getHost(),
            'port' => $redisConfig->getPort()
        ];
        $key = md5(serialize($config));
        if (!self::$client[$key]) {
            $Client = new Client($config);
            if ($redisConfig->getPasswd()) {
                $Client->auth($redisConfig->getPasswd());
            }
            self::$client[$key] = $Client;
            (new RedisConnectLog($config))();
        }
        return self::$client[$key];
    }
}
