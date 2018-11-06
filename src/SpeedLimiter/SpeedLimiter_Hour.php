<?php

namespace xltxlm\redis\SpeedLimiter;

use \xltxlm\redis\Features\SpeedLimiter;

/**
 * 每小时区间限速;
 */
class SpeedLimiter_Hour extends SpeedLimiter_Hour\SpeedLimiter_Hour_implements
{

    public function getcycletime(): int
    {
        return 3600;
    }

}