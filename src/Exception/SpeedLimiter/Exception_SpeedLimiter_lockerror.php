<?php

namespace xltxlm\redis\Exception\SpeedLimiter;

use xltxlm\exception\Exception;


/**
 * 每小时限量;
 */
class Exception_SpeedLimiter_lockerror extends Exception
{
    use Exception_SpeedLimiter_lockerror\Exception_SpeedLimiter_lockerror_implements;


}