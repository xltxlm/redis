<?php

namespace xltxlm\redis\test\BucketLimit\BucketLimit_Day;

use xltxlm\redis\BucketLimit\BucketLimit_Day;
use xltxlm\redis\testconfig\my;

/**
 *
 */
class BucketLimit_Day_Remain_num_134_0
{

    public function __invoke()
    {
        $key = 'abcall';
        $redisConfig = new my();
        $redisConfig->__invoke()->del($key . '-' . date('Ymd'));
        for ($i = 0; $i < 3; $i++) {
            $add = (new BucketLimit_Day($key, 8, $i))
                ->setRedisConfig($redisConfig)
                ->__invoke();
            \xltxlm\helper\Util::d($add);
        }
        $BucketLimit_Day = (new BucketLimit_Day($key, 8))
            ->setRedisConfig($redisConfig);
        $remain_num = $BucketLimit_Day->getRemain_num();
        \xltxlm\helper\Util::d($remain_num);
        assert($remain_num == 5);
        $consumed_num = $BucketLimit_Day->getConsumed_num();
        \xltxlm\helper\Util::d($consumed_num);
        assert($consumed_num == 3);
    }

}

