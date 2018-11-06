<?php
/**
 * Created by PhpStorm.
 * User: xialintai
 * Date: 2016/12/26
 * Time: 19:14.
 */

namespace xltxlm\redis;

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
        $redisclient = $this->getRedisConfig()->__invoke();

        $cacheData = $redisclient->get($this->getKey());
        if (empty($cacheData)) {
            $setex = null;
        } else {
            /** @var RedisData $unserialize */
            $unserialize = unserialize($cacheData);
            if ($unserialize instanceof RedisData) {
                $setex = $unserialize->getData();
                $this->setCached(true);
            } else {
                $setex = null;
            }
        }
        $this->value = $setex;

        return $setex;
    }
}
