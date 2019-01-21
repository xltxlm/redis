<?php

namespace xltxlm\redis\test\Features\Redis_LockKey;

use xltxlm\redis\Features\Redis_LockKey;
use xltxlm\redis\test\testconfig\my;

/**
 *
 */
class __invoke_63
{

    public function __invoke()
    {
        $redisclient = (new my())
            ->__invoke();
        $key = 'abcc';
        $redisclient->del($key);
        $redisclient->set($key, 'key from abc');

        $bool = (new Redis_LockKey())
            ->setRedisConfig(new my())
            ->setkey($key)
            ->setexpire(1)
            ->__invoke();
        \xltxlm\helper\Util::d($bool);
        \xltxlm\helper\Util::d($redisclient->get($key));
        assert($bool==false);
    }

}

