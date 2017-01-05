<?php
/**
 * Created by PhpStorm.
 * User: xialintai
 * Date: 2016/12/26
 * Time: 19:25.
 */

namespace kuaigeng\review\src\tests;

use xltxlm\redis\RedisCache;
use PHPUnit\Framework\TestCase;
use tests\redis\RedisConfigDemo;

class RedisCacheTest extends TestCase
{
    protected $key = 'abcd';

    public function test1()
    {
        $redisCache = (new RedisCache())
            ->setRedisConfig(new RedisConfigDemo())
            ->setKey($this->key)
            ->setExpire(2);
        $data = $redisCache
            ->__invoke();
        if ($data) {
            echo "有缓存数据:\n";
            print_r($data);
            echo "\n";
        } else {
            $redisCache
                ->setValue($this)
                ->__invoke();
            echo "写入缓存:\n";
        }
    }
}
