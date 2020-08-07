<?php

namespace xltxlm\redis\SpeedLimiter;


/**
 * 每小时区间限速;
 */
class SpeedLimiter_Hour extends SpeedLimiter_Hour\SpeedLimiter_Hour_implements
{

    public function getrealkey(): string
    {
        $this->realkey = $this->key . '-' . date('YmdH');
        return $this->realkey;
    }

    public function getcycletime(): int
    {
        return 3600;
    }

}