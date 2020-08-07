<?php

namespace xltxlm\redis\Features;


use xltxlm\redis\Exception\Redis_LockKey\Expire_Exception;
use xltxlm\redis\Exception\Redis_LockKey\LockFall_Exception;

/**
 * 锁定函数;
 */
class Redis_LockKey extends Redis_LockKey\Redis_LockKey_implements
{
    /**
     * Redis_LockKey constructor.
     */
    public function __construct(string $key = '', int $expire = 0)
    {
        if ($key) {
            $this->setkey($key);
        }
        if ($expire) {
            $this->setexpire($expire);
        }
    }

    public function __invoke(): bool
    {
        if ($this->getExpire() < 1) {
            throw new Expire_Exception();
        }
        /** @var \Redis $redis */
        $redis = $this->getRedisConfig()->__invoke();
        $waittimes = 0;
        do {
            //写入key,并且设置过期时间
            //设置上锁的时候，同时也给key设置一个过期时间，防止没有解锁，导致以后再也取不到锁了。
            if ($redis->set($this->getKey(), $this->getValue(), ['nx', 'ex' => $this->getExpire()])) {
                return true;
            }

            //锁定失败的时候抛出异常
            if ($this->getException_on_LockFail()) {
                throw (new LockFall_Exception())
                    ->setRedisConfig($this->getRedisConfig())
                    ->setRedis_LockKey($this);
            }
            //获取锁失败的时候，可以暂停
            if ($this->getTry_Wait_Second()) {
                $waittimes++;
                if ($waittimes > $this->getTry_Wait_Second()) {
                    return false;
                }
                //暂停1秒
                sleep(1);
            } else {
                return false;
            }
        } while (true);
    }

    /**
     * 使用内置的lua脚本来解锁。因为需要事务逻辑
     *
     * @return bool
     */
    public function Free(): bool
    {
        /** @var \Redis $redis */
        $redis = $this->getRedisConfig()->__invoke();
        return $redis->eval("if redis.call('get', KEYS[1]) == ARGV[1] then return redis.call('del', KEYS[1]) else return 0 end", [$this->getKey(), $this->getValue()], 1);
    }


}