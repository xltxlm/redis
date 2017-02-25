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
use xltxlm\redis\RedisClient;

/**
 * Redis 配置信息
 * Class RedisConfig.
 */
abstract class RedisConfig implements TestConfig
{
    protected $host = '127.0.0.1';
    protected $port = 6379;
    protected $passwd = '';

    /**
     * @return string
     */
    public function getPasswd(): string
    {
        return $this->passwd;
    }

    /**
     * @param string $passwd
     * @return static
     */
    public function setPasswd(string $passwd)
    {
        $this->passwd = $passwd;
        return $this;
    }


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
        $client = (new RedisClient)
            ->setRedisConfig($this);
        $message = "test message";
        $messageBack = $client->ping($message);
        return $messageBack;
    }

}
