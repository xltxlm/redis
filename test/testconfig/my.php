<?php

namespace xltxlm\redis\test\testconfig;

use \xltxlm\redis\Config\RedisConfig;

/**
 * @method \Redis __invoke()
 * 账户配置;
 */
class my extends RedisConfig
{
    use my\my_implements;

    protected $Tns = 'redis';
    protected $Password = 'redispasswd123';
    protected $Port = 6379;

}