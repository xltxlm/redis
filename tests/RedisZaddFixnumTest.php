<?php
/**
 * Created by PhpStorm.
 * User: xialintai
 * Date: 2017/1/5
 * Time: 11:12
 */

namespace xltxlm\redis\tests;


use PHPUnit\Framework\TestCase;
use xltxlm\redis\RedisZaddFixnum;
use xltxlm\redis\Util\ZaddUnit;

class RedisZaddFixnumTest extends TestCase
{

    public function testdesc()
    {
        $RedisZaddFixnum = (new RedisZaddFixnum())
            ->setConfig(new RedisConfigDemo())
            ->setFixnum(10)
            ->setKey("abc");
        for ($i = 1; $i <= 20; $i++) {
            $RedisZaddFixnum->setZaddUnit(
                (new ZaddUnit())
                    ->setName("name:".$i)
                    ->setScore($i)
            );
        }
        $RedisZaddFixnum->__invoke();
    }

    public function testasc()
    {
        $RedisZaddFixnum = (new RedisZaddFixnum())
            ->setConfig(new RedisConfigDemo())
            ->setOrderby(RedisZaddFixnum::ORDER_ASC)
            ->setFixnum(2)
            ->setKey("abc");
        for ($i = 1; $i <= 20; $i++) {
            $RedisZaddFixnum->setZaddUnit(
                (new ZaddUnit())
                    ->setName("name:".$i)
                    ->setScore($i)
            );
        }
        $RedisZaddFixnum->__invoke();
    }
}