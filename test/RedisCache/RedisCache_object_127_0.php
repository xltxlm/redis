<?php

namespace xltxlm\redis\test\RedisCache;
use xltxlm\redis\RedisCache;
use xltxlm\redis\test\testconfig\my;

/**
 *
 */
class RedisCache_object_127_0
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
            $setRedisConfig->setValue($this);
        }

        //再次取出来看看
        $cachedvalue = $setRedisConfig
            ->__invoke();
        \xltxlm\helper\Util::d($cachedvalue);
        assert($this instanceof $this);
    }

}

