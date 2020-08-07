<?php
/**
 * Created by PhpStorm.
 * User: xialintai
 * Date: 2016/12/26
 * Time: 17:05.
 */

namespace xltxlm\redis;

use xltxlm\logger\LoggerTrack;
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

    /**
     * @return bool
     * @throws \Exception
     */
    public function __invoke()
    {
        $loggerTrack = (new LoggerTrack())->setresource_type('redis');
        if (!$this->getExpire()) {
            $exception = "redis当作锁的时候，必须有超时时间.[尝试锁住：{$this->getKey()}]";
            $loggerTrack->setcontext(['exception' => $exception]);
            throw new \Exception($exception);
        }
        // Parameters passed using a named array:
        $this->setClient($this->getRedisConfig()->__invoke());
        $waittimes = 0;
        do {
            //写入key,并且设置过期时间
            if ($this->getClient()->set($this->getKey(), $this->getValue(), ['nx', 'ex' => $this->getExpire()])) {
                $loggerTrack->setcontext(["message" => "加锁成功:{$this->getKey()}"])->__invoke();
                return true;
            }
            if ($this->isWaitForunlock()) {
                $waittimes++;
                if ($waittimes > 10) {
                    $loggerTrack->setcontext(["exception" => "等待10次,加锁失败:{$this->getKey()}"])->__invoke();
                    return false;
                }
                usleep(10);
            } else {
                $loggerTrack->setcontext(["exception" => "加锁失败:{$this->getKey()}"])->__invoke();
                return false;
            }
        } while (true);
    }

    /**
     * 不能在析构的时候自动注销，因为多线程情况会父进程的锁会被子进程给注销掉
     *
     * @return mixed
     */
    public function free()
    {
        $loggerTrack = (new LoggerTrack())->setresource_type('redis')->setcontext(['message' => "释放锁：{$this->getKey()}"]);
        $eval = $this->getClient()->eval("if redis.call('get', KEYS[1]) == ARGV[1] then return redis.call('del', KEYS[1]) else return 0 end", [$this->getKey(), $this->getValue()], 1);
        if (!$eval) {
            $loggerTrack->setcontext(["exception" => "释放锁失败：{$this->getKey()}"]);
        }
        $loggerTrack->__invoke();
        return $eval;
    }
}
