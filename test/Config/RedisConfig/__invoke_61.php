<?php

namespace xltxlm\redis\test\Config\RedisConfig;

use xltxlm\redis\RedisCache;
use xltxlm\redis\test\testconfig\my;

/**
 *
 */
class __invoke_61
{

    public function __invoke()
    {
        $config = (new my());
        $redis = $config->__invoke();
        \xltxlm\helper\Util::d($redis);
        assert($redis instanceof \Redis);
    }

}

