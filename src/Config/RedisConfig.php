<?php
/**
 * Created by PhpStorm.
 * User: xialintai
 * Date: 2016/12/26
 * Time: 17:06.
 */

namespace xltxlm\redis\Config;

use Predis\Client;
use xltxlm\config\TestConfig;

/**
 * Redis 配置信息
 * Class RedisConfig.
 */
abstract class RedisConfig implements TestConfig
{
    protected $host = '127.0.0.1';
    protected $port = 6379;

    /**
     * @return string
     */
    final public function getHost(): string
    {
        return $this->host;
    }

    /**
     * @param string $host
     *
     * @return $this
     */
    final public function setHost(string $host)
    {
        $this->host = $host;

        return $this;
    }

    /**
     * @return string
     */
    final public function getPort(): string
    {
        return $this->port;
    }

    /**
     * @param string $port
     *
     * @return $this
     */
    final public function setPort(string $port)
    {
        $this->port = $port;

        return $this;
    }

    public function test()
    {
        // Parameters passed using a named array:
        $client = new Client(
            [
                'scheme' => 'tcp',
                'host' => $this->getHost(),
                'port' => $this->getPort(),
            ]
        );
        $message = "test message";
        $messageBack = $client->ping($message);
        return $messageBack;
    }

}
