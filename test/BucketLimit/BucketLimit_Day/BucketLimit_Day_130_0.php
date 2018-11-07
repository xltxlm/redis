<?php

namespace xltxlm\redis\test\BucketLimit\BucketLimit_Day;

use xltxlm\redis\BucketLimit\BucketLimit_Day;
use xltxlm\redis\testconfig\my;

/**
 *
 */
class BucketLimit_Day_130_0
{

    public function __invoke()
    {
        $key = 'abcf';
        $redisConfig = new my();
        $redisConfig->__invoke()->del($key . '-' . date('Ymd'));
        for ($i = 0; $i < 3; $i++) {
            $add = (new BucketLimit_Day($key, 3, $i))
                ->setRedisConfig($redisConfig)
                ->__invoke();
            \xltxlm\helper\Util::d($add);
        }
        $add = (new BucketLimit_Day($key, 3, 'new'))
            ->setRedisConfig($redisConfig)
            ->__invoke();
        \xltxlm\helper\Util::d($add);
    }

}

