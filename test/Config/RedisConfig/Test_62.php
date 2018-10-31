<?php
namespace xltxlm\redis\test\Config\RedisConfig;

use xltxlm\redis\testconfig\my;

/**
*
*/
class Test_62{

    public function __invoke()
    {
        $config = (new my());
        $redis = $config->__invoke();
        \xltxlm\helper\Util::d($redis);
        assert($redis instanceof \Redis);
        \xltxlm\helper\Util::d($config->Test());
        assert($config->Test());
    }

}

