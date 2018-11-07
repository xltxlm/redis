<?php

namespace xltxlm\redis\test\BucketLimit\BucketLimit_Day;

use xltxlm\redis\BucketLimit\BucketLimit_Day;
use xltxlm\redis\testconfig\my;

/**
 *
 */
class BucketLimit_Day_empty_131_0
{

    public function __invoke()
    {
        $key = 'abce';
        $redisConfig = new my();
        $redisConfig->__invoke()->del($key . '-' . date('Ymd'));

        $add = (new BucketLimit_Day($key, 3, 0))
            ->setRedisConfig($redisConfig)
            ->__invoke();
        $add = (new BucketLimit_Day($key, 3))
            ->setRedisConfig($redisConfig)
            ->__invoke();
        \xltxlm\helper\Util::d($add);
        assert($add == true);
    }

}

