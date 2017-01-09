<?php
/**
 * Created by PhpStorm.
 * User: xialintai
 * Date: 2016/12/26
 * Time: 17:14.
 */

namespace xltxlm\redis\tests;

use PHPUnit\Framework\TestCase;
use xltxlm\redis\RedisClient;
use xltxlm\redis\LockKey;

class LockKeyTest extends TestCase
{
    /**
     * 证明设置进去的key会在时间过期之后消失.
     */
    public function test1()
    {
        $key = 'abc';
        (new LockKey())
            ->setRedisConfig(new RedisConfigDemo())
            ->setKey($key)
            ->setValue(date('r'))
            ->setExpire(3)
            ->__invoke();
        for ($i = 0; $i <= 5; ++$i) {
            echo $i.":\n";
            echo (new RedisClient())
                ->setRedisConfig(new RedisConfigDemo())
                ->get($key);
            sleep(1);
            echo "\n";
        }
    }

    public function testlock()
    {
        $key = __METHOD__;
        $i = 0;
        while ($i++ < 10) {
            $LockKey = (new LockKey())
                ->setRedisConfig(new RedisConfigDemo())
                ->setKey($key)
                ->setValue(date('r'))
                ->setExpire(3)
                ->__invoke();
            var_dump($LockKey);
        }
    }

}
