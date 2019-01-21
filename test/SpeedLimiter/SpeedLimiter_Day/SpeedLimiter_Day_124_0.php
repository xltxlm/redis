<?php

namespace xltxlm\redis\test\SpeedLimiter\SpeedLimiter_Day;

use xltxlm\redis\SpeedLimiter\SpeedLimiter_Day;
use xltxlm\redis\test\testconfig\my;

/**
 *
 */
class SpeedLimiter_Day_124_0
{

    public function __invoke()
    {
        $redisConfig = (new my());
        $key = 'abc';
        $num = 4;
        $redisConfig->__invoke()->del("abc".'-' . date('Ymd'));
        for ($i = 0; $i < $num; $i++) {
            $locked = (new SpeedLimiter_Day($key, 3))
                ->setRedisConfig($redisConfig)
                ->__invoke();
            \xltxlm\helper\Util::d($locked);
        }
        assert($locked == false);
    }

}

