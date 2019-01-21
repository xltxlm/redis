<?php

namespace xltxlm\redis\test\SpeedLimiter\SpeedLimiter_Day;

use xltxlm\redis\Exception\SpeedLimiter\Exception_SpeedLimiter_noconfig;
use xltxlm\redis\Exception\SpeedLimiter\Exception_SpeedLimiter_nokey;
use xltxlm\redis\Exception\SpeedLimiter\Exception_SpeedLimiter_outofspeed;
use xltxlm\redis\SpeedLimiter\SpeedLimiter_Day;
use xltxlm\redis\test\testconfig\my;

/**
 *
 */
class SpeedLimiter_Day_exception_125_0
{

    public function __invoke()
    {
        $redisConfig = (new my());
        $key = 'abc';
        $num = 3;
        $redisConfig->__invoke()->del("abc".'-' . date('Ymd'));
        for ($i = 0; $i < $num; $i++) {
            $locked = (new SpeedLimiter_Day($key, 3))
                ->setRedisConfig($redisConfig)
                ->setException_on_LockFail(true)
                ->__invoke();
            \xltxlm\helper\Util::d($locked);
        }

        try {
            $locked = (new SpeedLimiter_Day($key, 3))
                ->setRedisConfig($redisConfig)
                ->setException_on_LockFail(true)
                ->__invoke();
        } catch (Exception_SpeedLimiter_noconfig $e) {
        } catch (Exception_SpeedLimiter_nokey $e) {
        } catch (Exception_SpeedLimiter_outofspeed $e) {

        }
        assert($e instanceof Exception_SpeedLimiter_outofspeed);
    }

}

