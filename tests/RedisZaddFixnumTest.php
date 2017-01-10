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
        $datas = $RedisZaddFixnum->__invoke();
        //验证是否倒序
        $old = 0;
        foreach ($datas as $data) {
            if ($old) {
                $this->assertGreaterThan($data->getScore(), $old);
            }
            $old = $data->getScore();
        }
    }

    public function testasc()
    {
        $RedisZaddFixnum = (new RedisZaddFixnum())
            ->setConfig(new RedisConfigDemo())
            ->setOrderby(RedisZaddFixnum::ORDER_ASC)
            ->setFixnum(2)
            ->setKey("abcd");
        for ($i = 1; $i <= 20; $i++) {
            $RedisZaddFixnum->setZaddUnit(
                (new ZaddUnit())
                    ->setName("name".$i)
                    ->setScore($i + 10)
            );
        }
        $datas = $RedisZaddFixnum->__invoke();
        $this->assertTrue(!empty($datas));
        $this->assertInstanceOf(ZaddUnit::class, $datas[0]);

        //验证是否正序
        $old = 0;
        foreach ($datas as $data) {
            if ($old) {
                $this->assertGreaterThan($old, $data->getScore());
            }
            $old = $data->getScore();
        }

    }
}