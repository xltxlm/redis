<?php

namespace xltxlm\redis\test\Features\Redis_LockKey;

use xltxlm\redis\Exception\Redis_LockKey\LockFall_Exception;
use xltxlm\redis\Features\Redis_LockKey;
use xltxlm\redis\testconfig\my;

/**
 *
 */
class __invoke_65
{

    public function __invoke()
    {
        $redisConfig = new my();
        $redisclient = ($redisConfig)
            ->__invoke();
        $key = 'abcc';
        $redisclient->del($key);
        $redisclient->set($key, 'key from abc');

        try {
            $setException_on_LockFail = (new Redis_LockKey())
                ->setRedisConfig($redisConfig)
                ->setkey($key)
                ->setexpire(1)
                ->setException_on_LockFail(true);
            $bool = $setException_on_LockFail
                ->__invoke();
        } catch (LockFall_Exception $e) {
            \xltxlm\helper\Util::d($e->getRedisConfig());
            assert($e->getRedisConfig() === $redisConfig);
            \xltxlm\helper\Util::d($e->getRedis_LockKey());
            assert($e->getRedis_LockKey() === $setException_on_LockFail);
        }
        \xltxlm\helper\Util::d($bool);
        \xltxlm\helper\Util::d($redisclient->get($key));
        assert($bool == false);
    }

}

