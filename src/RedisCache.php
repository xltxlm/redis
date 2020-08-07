<?php
/**
 * Created by PhpStorm.
 * User: xialintai
 * Date: 2016/12/26
 * Time: 19:14.
 */

namespace xltxlm\redis;

use xltxlm\logger\LoggerTrack;
use xltxlm\redis\Util\RedisData;

class RedisCache extends RedisCache\RedisCache_implements
{
    /**
     * RedisCache constructor.
     */
    public function __construct(string $key = null, int $expire = 0)
    {
        if ($key) {
            $this->setkey($key);
        }

        if ($expire) {
            $this->setexpire($expire);
        }

    }

    /**
     * @param mixed $value
     *
     * @return RedisCache
     */
    public function setValue($value): RedisCache
    {
        /** @var \Redis $redisclient */
        $redisclient = $this->getRedisConfig()->__invoke();
        $RedisData = (new RedisData())
            ->setData($value);
        $this->value = serialize($RedisData);
        $redisclient->setex($this->getKey(), $this->getExpire(), $this->getValue());

        return $this;
    }


    /**
     * @return int|mixed|null
     */
    public function __invoke()
    {
        /** @var \Redis $redisclient */
        $redisclient = $this->getRedisConfig()->__invoke();

        $cacheData = $redisclient->get($this->getKey());
        if (empty($cacheData)) {
            (new LoggerTrack())->setresource_type('redis')->setcontext(['message' => "缓存不存在:{$this->getKey()}"])->__invoke();
            $setex = null;
        } else {
            /** @var RedisData $unserialize */
            $unserialize = unserialize($cacheData);
            if ($unserialize instanceof RedisData) {
                $setex = $unserialize->getData();
                $this->setCached(true);
                (new LoggerTrack())->setresource_type('redis')->setcontext(['message' => "命中缓存成功:{$this->getKey()}"])->__invoke();
            } else {
                (new LoggerTrack())->setresource_type('redis')->setcontext(['message' => "缓存解码失败:{$this->getKey()}"])->__invoke();
                $setex = null;
            }
        }
        $this->value = $setex;

        return $setex;
    }
}
