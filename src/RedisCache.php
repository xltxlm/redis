<?php
/**
 * Created by PhpStorm.
 * User: xialintai
 * Date: 2016/12/26
 * Time: 19:14.
 */

namespace xltxlm\redis;

use Predis\Client;
use xltxlm\redis\Config\RedisConfig;
use xltxlm\logger\Operation\Action\RedisRunLog;
use xltxlm\redis\Util\RedisData;

final class RedisCache
{
    protected $key = '';
    /** @var Client */
    private $client;
    /** @var mixed */
    protected $value;
    /** @var int key过期自动解锁时间 */
    protected $expire = 86400;
    /** @var bool 准确的在今天过后失效 */
    protected $expireToday = false;
    /** @var RedisConfig */
    protected $redisConfig;

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
        $this->client = (new RedisClient)
            ->setRedisConfig($this->getRedisConfig());

        $start = microtime(true);
        //如果传递值,意味是设置
        if ($this->getValue()) {
            if ($this->isExpireToday()) {
                $Expire = strtotime('tomorrow') - time();
                $setex = $this->client->setex($this->getKey(), $Expire, $this->getValue());
            } else {
                $setex = $this->client->setex($this->getKey(), $this->getExpire(), $this->getValue());
            }
        } else {
            $str = $this->client->get($this->getKey());
            if (empty($str)) {
                $setex = null;
            } else {
                /** @var RedisData $unserialize */
                $unserialize = unserialize($str);
                if ($unserialize instanceof RedisData) {
                    $setex = $unserialize->getData();
                } else {
                    $setex = null;
                }
            }
        }
        $time = sprintf('%.4f', microtime(true) - $start);
        (new RedisRunLog($this))
            ->setRunTime($time)
            ->__invoke();

        return $setex;
    }
}
