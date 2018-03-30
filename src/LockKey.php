<?php
/**
 * Created by PhpStorm.
 * User: xialintai
 * Date: 2016/12/26
 * Time: 17:05.
 */

namespace xltxlm\redis;

use Predis\Client;
use xltxlm\logger\Operation\Action\RedisRunLog;
use xltxlm\redis\Config\RedisConfig;

/**
 * redis锁,保证一个原子内锁上去
 * Class Lock.
 */
final class LockKey
{
    /** @var RedisConfig */
    protected $redisConfig;
    /** @var string 需要锁定的标志 */
    protected $key = '';
    /** @var string 值 */
    protected $value = '';
    /** @var int key过期自动解锁时间 */
    protected $expire = 0;
    /** @var \Redis redis链接客户端 */
    protected $client;

    /**
     * @return \Redis
     */
    public function getClient(): \Redis
    {
        return $this->client;
    }

    /**
     * @param \Redis $client
     * @return LockKey
     */
    public function setClient(\Redis $client): LockKey
    {
        $this->client = $client;
        return $this;
    }


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
     * @return LockKey
     */
    public function setRedisConfig(RedisConfig $redisConfig): LockKey
    {
        $this->redisConfig = $redisConfig;

        return $this;
    }

    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @param string $key
     *
     * @return LockKey
     */
    public function setKey(string $key): LockKey
    {
        $this->key = $key;

        return $this;
    }

    /**
     * @return int
     */
    public function getExpire(): int
    {
        return $this->expire;
    }

    /**
     * @param int $expire
     *
     * @return LockKey
     */
    public function setExpire(int $expire): LockKey
    {
        $this->expire = $expire;

        return $this;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value ?: date('Y-m-d H:i:s');
    }

    /**
     * @param string $value
     *
     * @return LockKey
     */
    public function setValue(string $value): LockKey
    {
        $this->value = $value;

        return $this;
    }

    public function __invoke()
    {
        if (!$this->getExpire()) {
            throw new \Exception("redis当作锁的时候，必须有超时时间");
        }
        // Parameters passed using a named array:
        $this->setClient($this->getRedisConfig()->__invoke());

        //写入key,并且设置过期时间
        if ($this->getClient()->set($this->getKey(), $this->getValue(), ['nx', 'ex' => $this->getExpire()])) {
            return true;
        }

        return false;
    }
}
