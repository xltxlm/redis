<?php

namespace xltxlm\redis\test\Config\RedisConfig;

use xltxlm\redis\testconfig\my;

/**
 *
 */
class 链接错误异常_173_0
{

    public function __invoke()
    {
        $config = (new my())->setTns('abc');
        p($config->Test());
    }

}

