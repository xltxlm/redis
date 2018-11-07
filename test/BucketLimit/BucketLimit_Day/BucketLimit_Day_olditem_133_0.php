<?php

namespace xltxlm\redis\test\BucketLimit\BucketLimit_Day;

use xltxlm\redis\BucketLimit\BucketLimit_Day;
use xltxlm\redis\testconfig\my;

/**
 *
 */
class BucketLimit_Day_olditem_133_0
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
        $add = (new BucketLimit_Day($key, 3, 1))
            ->setRedisConfig($redisConfig)
            ->__invoke();
        \xltxlm\helper\Util::d($add);
        assert($add == true);

        $add = (new BucketLimit_Day($key, 3, 0))
            ->setRedisConfig($redisConfig)
            ->__invoke();
        \xltxlm\helper\Util::d($add);
        assert($add == true);

        $add = (new BucketLimit_Day($key, 3, 3))
            ->setRedisConfig($redisConfig)
            ->__invoke();
        \xltxlm\helper\Util::d($add);
        assert($add == false);
    }

}

