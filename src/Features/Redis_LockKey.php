<?php

namespace xltxlm\redis\Features;


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
            throw new \xltxlm\redis\Exception\Redis_LockKey\Expire_Exception();
        }
        $waittimes = 0;
        do {
            //写入key,并且设置过期时间
            if ($this->getRedisConfig()->__invoke()->set($this->getKey(), $this->getValue(), ['nx', 'ex' => $this->getExpire()])) {
                return true;
            }

            //锁定失败的时候抛出异常
            if ($this->getException_on_LockFail()) {
                throw (new \xltxlm\redis\Exception\Redis_LockKey\LockFall_Exception())
                    ->setRedisConfig($this->getRedisConfig())
                    ->setRedis_LockKey($this);
            }
            if ($this->getTry_Wait_Second()) {
                $waittimes++;
                if ($waittimes > $this->getTry_Wait_Second()) {
                    return false;
                }
                //暂停半秒
                sleep(1);
            } else {
                return false;
            }
        } while (true);
    }

    public function Free(): bool
    {
        return $this->getRedisConfig()->__invoke()->eval("if redis.call('get', KEYS[1]) == ARGV[1] then return redis.call('del', KEYS[1]) else return 0 end", [$this->getKey(), $this->getValue()], 1);
    }


}