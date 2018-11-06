<?php

namespace xltxlm\redis\SpeedLimiter;

use \xltxlm\redis\Features\SpeedLimiter;

/**
 * 每日区间限速;
 */
class SpeedLimiter_Day extends SpeedLimiter_Day\SpeedLimiter_Day_implements
{
    public function getcycletime(): int
    {
        return 3600 * 24;
    }


}