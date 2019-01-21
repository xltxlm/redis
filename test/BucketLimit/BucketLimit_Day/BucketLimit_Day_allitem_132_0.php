<?php

namespace xltxlm\redis\test\BucketLimit\BucketLimit_Day;

use xltxlm\redis\BucketLimit\BucketLimit_Day;
use xltxlm\redis\test\testconfig\my;

/**
 *
 */
class BucketLimit_Day_allitem_132_0
{

    public function __invoke()
    {
        $key = 'abcall';
        $redisConfig = new my();
        $redisConfig->__invoke()->del($key . '-' . date('Ymd'));
        for ($i = 0; $i < 3; $i++) {
            $add = (new BucketLimit_Day($key, 3, $i))
                ->setRedisConfig($redisConfig)
                ->__invoke();
            \xltxlm\helper\Util::d($add);
        }
        $allitem = (new BucketLimit_Day($key))
            ->setRedisConfig($redisConfig)
            ->getAllItems();

        \xltxlm\helper\Util::d($allitem);
    }

}

