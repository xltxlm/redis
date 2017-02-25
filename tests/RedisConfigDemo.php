<?php
/**
 * Created by PhpStorm.
 * User: xialintai
 * Date: 2016/12/26
 * Time: 17:21.
 */

namespace xltxlm\redis\tests;

use xltxlm\redis\Config\RedisConfig;

class RedisConfigDemo extends RedisConfig
{
    protected $host = '127.0.0.1';
    protected $passwd = 'redispass123';
}
