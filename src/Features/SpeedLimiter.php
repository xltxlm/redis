<?php

namespace xltxlm\redis\Features;


use xltxlm\redis\Exception\SpeedLimiter\Exception_SpeedLimiter_noconfig;
use xltxlm\redis\Exception\SpeedLimiter\Exception_SpeedLimiter_nokey;
use xltxlm\redis\Exception\SpeedLimiter\Exception_SpeedLimiter_outofspeed;

/**
 * 限速光卡;
 */
Trait SpeedLimiter
{
    use SpeedLimiter\SpeedLimiter_implements;


    /**
     * SpeedLimiter constructor.
     */
    public function __construct(string $key = null, int $maxtimes = 0)
    {
        if ($key) {
            $this->setkey($key);
        }
        if ($maxtimes) {
            $this->setmaxtimes($maxtimes);
        }
    }

    public function __invoke(): bool
    {
        //判断参数
        if (empty($this->key)) {
            throw new Exception_SpeedLimiter_nokey();
        }
        if (empty($this->RedisConfig)) {
            throw new Exception_SpeedLimiter_noconfig();
        }
        /** @var \Redis $redisclient */
        $redisclient = $this->getRedisConfig()->__invoke();
        //查出当前已经使用的额度
        $use_times = $redisclient->get($this->getrealkey());
        //超速了
        if ($use_times >= $this->getMaxtimes()) {
            //超速抛出异常
            if ($this->getException_on_LockFail()) {
                throw new Exception_SpeedLimiter_outofspeed();
            }
            //或者超速返回失败
            return false;
        }
        $num = $redisclient->incr($this->getrealkey());
        if ($num == 1) {
            //第一次加设置对应的过期时间
            $redisclient->expire($this->getrealkey(), $this->getcycletime());
        }
        //超速了
        if ($num >= $this->getMaxtimes()) {
            if ($this->getException_on_LockFail()) {
                throw new Exception_SpeedLimiter_outofspeed();
            }
            return false;
        }
        return true;
    }


}