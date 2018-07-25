<?php
/**
 * Created by PhpStorm.
 * User: xialintai
 * Date: 2016/12/26
 * Time: 17:06.
 */

namespace xltxlm\redis\Config;

use xltxlm\config\TestConfig;

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

    /**
     * 返回自增id序列
     * @return  string
     */
    public function snownum()
    {
        $client = $this->__invoke();
        $seqnum = $client->rPop('snownum_list');
        $取不出序号 = !$seqnum;
        if ($取不出序号) {
            throw new \Exception("序号分发器取不出自增id: $seqnum");
        }
        return $seqnum;
    }

    /**
     * @return \Redis 返回redis对象
     */
    public function __invoke()
    {
        /** @var \Redis[] $client */
        static $client = [];

        $key = md5(serialize($this)) . '@' . posix_getpid();
        if (!$client[$key]) {
            $client[$key] = new \Redis();
            $client[$key]->connect($this->getHost(), $this->getPort());
            if ($this->getPasswd()) {
                $client[$key]->auth($this->getPasswd());
            }
        }
        return $client[$key];
    }

    public function test()
    {
        $client = $this->__invoke();
        $message = "test message";
        $messageBack = $client->ping($message);
        return $messageBack;
    }

}
