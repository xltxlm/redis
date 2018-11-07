<?php

namespace xltxlm\redis\SpeedLimiter;

use \xltxlm\redis\Features\SpeedLimiter;

/**
 * 每日区间限速;
 */
class SpeedLimiter_Day extends SpeedLimiter_Day\SpeedLimiter_Day_implements
{
    public function getrealkey(): string
    {
        $this->realkey = $this->key . '-' . date('Ymd');
        return $this->realkey;
    }

    public function getcycletime(): int
    {
        $leftseconds = strtotime('tomorrow') - strtotime('today');
        return $leftseconds;
    }


}