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
use xltxlm\logger\Operation\Connect\RedisConnectLog;

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
        $this->redisConfig = $redisConfig;
        // Parameters passed using a named array:
        $config = [
            'scheme' => 'tcp',
            'host' => $redisConfig->getHost(),
            'port' => $redisConfig->getPort()
        ];
        $key = md5(serialize($config));
        if (!self::$client[$key]) {
            $start = microtime(true);
            $Client = new Client($config);
            if ($redisConfig->getPasswd()) {
                $Client->auth($redisConfig->getPasswd());
            }
            self::$client[$key] = $Client;
            $time = sprintf('%.4f', microtime(true) - $start);
            (new RedisConnectLog($config))->setRunTime($time)();
        }
        return self::$client[$key];
    }
}
