<?php
/**
 * Created by PhpStorm.
 * User: xialintai
 * Date: 2016/12/26
 * Time: 17:05.
 */

namespace xltxlm\redis;

use xltxlm\logger\Mysqllog\Mysqllog_TraitClass;
use xltxlm\logger\Thelostlog\Thelostlog_redis;
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

    /** @var bool 死循环等到锁被释放 */
    protected $waitForunlock = false;

    /**
     * @return bool
     */
    public function isWaitForunlock(): bool
    {
        return $this->waitForunlock;
    }

    /**
     * @param bool $waitForunlock
     * @return LockKey
     */
    public function setWaitForunlock(bool $waitForunlock): LockKey
    {
        $this->waitForunlock = $waitForunlock;
        return $this;
    }


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
        return $this->value = $this->value ?: date('Y-m-d H:i:s');
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
        $waittimes = 0;
        do {
            //写入key,并且设置过期时间
            if ($this->getClient()->set($this->getKey(), $this->getValue(), ['nx', 'ex' => $this->getExpire()])) {
                $thelostlog_redis = (new Thelostlog_redis("加锁成功:{$this->getKey()}"));
                unset($thelostlog_redis);
                return true;
            }
            if ($this->isWaitForunlock()) {
                $waittimes++;
                if ($waittimes > 1000) {
                    $thelostlog_redis = (new Thelostlog_redis("等待1000次,加锁失败:{$this->getKey()}"))
                    ->setmessage_type(Mysqllog_TraitClass::MESSAGETYPE_ERROR);
                    unset($thelostlog_redis);
                    return false;
                }
                usleep(10);
            } else {
                $thelostlog_redis = (new Thelostlog_redis("加锁失败:{$this->getKey()}"))
                ->setmessage_type(Mysqllog_TraitClass::MESSAGETYPE_ERROR);
                unset($thelostlog_redis);
                return false;
            }
        } while (true);
    }

    /**
     * 不能在析构的时候自动注销，因为多线程情况会父进程的锁会被子进程给注销掉
     * @return mixed
     */
    public function free()
    {
        return $this->getClient()->eval("if redis.call('get', KEYS[1]) == ARGV[1] then return redis.call('del', KEYS[1]) else return 0 end", [$this->getKey(), $this->getValue()], 1);
    }
}
