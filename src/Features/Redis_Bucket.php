<?php

namespace xltxlm\redis\Features;


/**
 * 限制每天的额度;
 */
Trait Redis_Bucket
{
    use Redis_Bucket\Redis_Bucket_implements;


    /**
     * Redis_Bucket constructor.
     */
    public function __construct(string $key = '', int $maxtimes = 0, $value = null)
    {
        if ($key) {
            $this->setkey($key);
        }

        if ($maxtimes) {
            $this->setmaxtimes($maxtimes);
        }
        if (isset($value)) {
            $this->setvalue($value);
        }
    }

    public function getAllItems(): array
    {
        $redisclient = $this->redisclient();
        return $redisclient->sMembers($this->getrealkey());
    }

    public function getRemain_num(): int
    {
        $this->Remain_num = $this->getmaxtimes() - $this->getConsumed_num();
        return $this->Remain_num;
    }

    public function getConsumed_num(): int
    {
        $redisclient = $this->redisclient();
        $this->Consumed_num = $redisclient->sCard($this->getrealkey());
        return $this->Consumed_num;
    }


    public function __invoke(): bool
    {
        $redisclient = $this->redisclient();
        $有设置写入值 = $this->getvalue() || strlen($this->getvalue()) > 0;

        //排队处理
        $Redis_LockKey = (new Redis_LockKey($this->key . '-lock', 1))
            ->setRedisConfig($this->getRedisConfig())
            ->setTry_Wait_Second(3);
        $串行 = $Redis_LockKey
            ->__invoke();
        if ($串行 == false) {
            $Redis_LockKey->free();
            return false;
        }

        $times = $redisclient->sCard($this->getrealkey());
        //超速了
        if ($times >= $this->getMaxtimes()) {
            $Redis_LockKey->free();
            //如果设置的是老元素,那么可以继续
            if ($有设置写入值 && $redisclient->sIsMember($this->getrealkey(), $this->getvalue())) {
                return true;
            }

            if ($this->getException_on_LockFail()) {
                throw new \xltxlm\redis\Exception\SpeedLimiter\Exception_SpeedLimiter_outofspeed();
            }
            return false;
        }
        if ($times = 1) {
            //第一次加设置对应的过期时间
            $redisclient->expire($this->getrealkey(), $this->getexpire());
        }
        //如果有值,设置进去
        if ($有设置写入值) {
            $redisclient->sAdd($this->getrealkey(), $this->getvalue());
        }
        $Redis_LockKey->free();
        return true;
    }

    private function redisclient(): \Redis
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
        return $redisclient;
    }


}