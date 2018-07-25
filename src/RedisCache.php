<?php
/**
 * Created by PhpStorm.
 * User: xialintai
 * Date: 2016/12/26
 * Time: 19:14.
 */

namespace xltxlm\redis;

use xltxlm\redis\Config\RedisConfig;
use xltxlm\logger\Operation\Action\RedisRunLog;
use xltxlm\redis\Util\RedisData;

final class RedisCache
{
    protected $key = '';
    /** @var \Redis */
    private $client;
    /** @var mixed */
    protected $value;
    /** @var int key过期自动解锁时间 */
    protected $expire = 86400;
    /** @var bool 准确的在今天过后失效 */
    protected $expireToday = false;
    /** @var RedisConfig */
    protected $redisConfig;

    /** @var bool 判断是否已经存在的标志，不能取值去进行判断！ */
    protected $cached = false;

    /**
     * @return bool
     */
    public function isCached(): bool
    {
        return $this->cached;
    }

    /**
     * @param bool $cached
     * @return RedisCache
     */
    public function setCached(bool $cached): RedisCache
    {
        $this->cached = $cached;
        return $this;
    }


    /**
     * @return \Redis
     */
    public function getClient(): \Redis
    {
        return $this->client;
    }

    /**
     * @param \Redis $client
     * @return RedisCache
     */
    public function setClient(\Redis $client): RedisCache
    {
        $this->client = $client;
        return $this;
    }


    /**
     * @return RedisConfig
     */
    public function getRedisConfig(): RedisConfig
    {
        return $this->redisConfig;
    }

    /**
     * @param RedisConfig $redisConfig
     *
     * @return RedisCache
     */
    public function setRedisConfig(RedisConfig $redisConfig): RedisCache
    {
        $this->redisConfig = $redisConfig;

        return $this;
    }

    /**
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @param string $key
     *
     * @return RedisCache
     */
    public function setKey(string $key): RedisCache
    {
        $this->key = $key;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     *
     * @return RedisCache
     */
    public function setValue($value): RedisCache
    {
        $RedisData = (new RedisData())
            ->setData($value);
        $this->value = serialize($RedisData);

        return $this;
    }

    /**
     * @return int
     */
    public function getExpire(): int
    {
        return $this->expire;
    }

    /**
     * @param int $expire
     *
     * @return RedisCache
     */
    public function setExpire(int $expire): RedisCache
    {
        $this->expire = $expire;

        return $this;
    }

    /**
     * @return bool
     */
    public function isExpireToday(): bool
    {
        return $this->expireToday;
    }

    /**
     * @param bool $expireToday
     *
     * @return RedisCache
     */
    public function setExpireToday(bool $expireToday): RedisCache
    {
        $this->expireToday = $expireToday;

        return $this;
    }

    /**
     * @return int
     */
    public function delete()
    {
        return $this->client->del([$this->key]);
    }

    /**
     * @return int|mixed|null
     */
    public function __invoke()
    {
        $this->setClient($this->getRedisConfig()->__invoke());

        $redisRunLog = (new RedisRunLog($this))
            ->setKey($this->getKey());
        //如果传递值,意味是设置
        if ($this->getValue()) {
            if ($this->isExpireToday()) {
                $Expire = strtotime('tomorrow') - time();
                $setex = $this->client->setex($this->getKey(), $Expire, $this->getValue());
            } else {
                $setex = $this->client->setex($this->getKey(), $this->getExpire(), $this->getValue());
            }
        } else {
            $cacheData = $this->client->get($this->getKey());
            if (empty($cacheData)) {
                $setex = null;
            } else {
                /** @var RedisData $unserialize */
                $unserialize = unserialize($cacheData);
                if ($unserialize instanceof RedisData) {
                    $setex = $unserialize->getData();
                    $redisRunLog->setCached(true);
                    $this->setCached(true);
                } else {
                    $setex = null;
                }
            }
        }
        $redisRunLog
            ->__invoke();

        return $setex;
    }
}
