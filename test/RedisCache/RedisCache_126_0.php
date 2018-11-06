<?php

namespace xltxlm\redis\test\RedisCache;

use xltxlm\redis\RedisCache;
use xltxlm\redis\testconfig\my;

/**
 *
 */
class RedisCache_126_0
{

    public function __invoke()
    {
        $key = 'abcd';

        $redisConfig = new my();
        $redisConfig->__invoke()->del($key);

        $setRedisConfig = (new RedisCache($key, 10))
            ->setRedisConfig($redisConfig);
        $cachedvalue = $setRedisConfig
            ->__invoke();
        \xltxlm\helper\Util::d($cachedvalue);
        assert($cachedvalue == null);
        \xltxlm\helper\Util::d($setRedisConfig->getcached());
        assert($setRedisConfig->getcached() == false);
        if ($setRedisConfig->getcached()) {

        } else {
            $setRedisConfig->setValue('dddd');
        }

        //再次取出来看看
        $cachedvalue = $setRedisConfig
            ->__invoke();
        \xltxlm\helper\Util::d($cachedvalue);
        assert($cachedvalue == 'dddd');

    }

}

