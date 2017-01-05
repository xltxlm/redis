<?php
/**
 * Created by PhpStorm.
 * User: xialintai
 * Date: 2017/1/5
 * Time: 10:59
 */

namespace xltxlm\redis\tests;


use PHPUnit\Framework\TestCase;

class RedisConfigTest extends TestCase
{

    public function test1()
    {
        (new RedisConfigDemo)
            ->test();
    }
}