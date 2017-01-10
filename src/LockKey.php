<?php
/**
 * Created by PhpStorm.
 * User: xialintai
 * Date: 2016/12/26
 * Time: 17:05.
 */

namespace xltxlm\redis;

use Predis\Client;
use xltxlm\redis\Config\RedisConfig;

/**
 * redis锁
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
        // Parameters passed using a named array:
        $client = new Client(
            [
                'scheme' => 'tcp',
                'host' => $this->getRedisConfig()->getHost(),
                'port' => $this->getRedisConfig()->getPort(),
            ]
        );
        //写入key,并且设置过期时间
        if ($client->setnx($this->getKey(), $this->getValue())) {
            if (!empty($this->getExpire())) {
                $client->expire($this->getKey(), $this->getExpire());
            }

            return true;
        }

        return false;
    }
}
