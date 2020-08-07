<?php

namespace xltxlm\redis\Features;


use xltxlm\redis\Exception\SpeedLimiter\Exception_SpeedLimiter_lockerror;
use xltxlm\redis\Exception\SpeedLimiter\Exception_SpeedLimiter_noconfig;
use xltxlm\redis\Exception\SpeedLimiter\Exception_SpeedLimiter_nokey;
use xltxlm\redis\Exception\SpeedLimiter\Exception_SpeedLimiter_outofspeed;

/**
 * 限制每天的额度-桶 map; 应用于限制给某个人一天之内之内推荐N给内容，超出了就再会，
 * 参考类：  \xltxlm\redis\BucketLimit\BucketLimit_Day
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
        $获取业务锁 = $Redis_LockKey
            ->__invoke();
        //取锁失败了
        if ($获取业务锁 == false) {
            $Redis_LockKey->free();
            throw new Exception_SpeedLimiter_lockerror("{$this->key}-lock lock error");
        }

        //获取当前桶里面元素的个数
        $item_nums = $redisclient->sCard($this->getrealkey());
        //超速了
        if ($item_nums >= $this->getMaxtimes()) {
            $Redis_LockKey->free();
            //如果设置的是老元素,那么可以继续
            if ($有设置写入值 && $redisclient->sIsMember($this->getrealkey(), $this->getvalue())) {
                return true;
            }

            if ($this->getException_on_LockFail()) {
                throw new Exception_SpeedLimiter_outofspeed();
            }
            return false;
        }
        //第一次加设置对应的过期时间
        if ($item_nums = 1) {
            $redisclient->expire($this->getrealkey(), $this->getexpire());
        }
        //如果有值,设置进去
        if ($有设置写入值) {
            $redisclient->sAdd($this->getrealkey(), $this->getvalue());
        }
        $Redis_LockKey->free();
        return true;
    }

    /**
     * @return \Redis
     * @throws Exception_SpeedLimiter_noconfig
     * @throws Exception_SpeedLimiter_nokey
     */
    private function redisclient(): \Redis
    {
        //判断参数
        if (empty($this->key)) {
            throw new Exception_SpeedLimiter_nokey();
        }
        if (empty($this->RedisConfig)) {
            throw new Exception_SpeedLimiter_noconfig();
        }
        //
        $redisclient = $this->getRedisConfig()->__invoke();
        return $redisclient;
    }


}