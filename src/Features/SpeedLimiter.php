<?php

namespace xltxlm\redis\Features;


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
            throw new \xltxlm\redis\Exception\SpeedLimiter\Exception_SpeedLimiter_nokey();
        }
        if (empty($this->RedisConfig)) {
            throw new \xltxlm\redis\Exception\SpeedLimiter\Exception_SpeedLimiter_noconfig();
        }
        //
        $redisclient = $this->getRedisConfig()->__invoke();
        $times = $redisclient->get($this->getrealkey());
        //超速了
        if ($times >= $this->getMaxtimes()) {
            if ($this->getException_on_LockFail()) {
                throw new \xltxlm\redis\Exception\SpeedLimiter\Exception_SpeedLimiter_outofspeed();
            }
            return false;
        }
        $num = $redisclient->incr($this->getrealkey());
        if ($num == 1) {
            //第一次加设置对应的过期时间
            $redisclient->expire($this->getrealkey(), $this->getcycletime());
        }
        //超速了
        if ($times >= $this->getMaxtimes()) {
            if ($this->getException_on_LockFail()) {
                throw new \xltxlm\redis\Exception\SpeedLimiter\Exception_SpeedLimiter_outofspeed();
            }
            return false;
        }
        return true;
    }


}