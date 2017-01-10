<?php
/**
 * Created by PhpStorm.
 * User: xialintai
 * Date: 2017/1/5
 * Time: 10:54.
 */

namespace xltxlm\redis;

use Predis\Client;
use xltxlm\redis\Config\RedisConfig;
use xltxlm\redis\Util\ZaddUnit;

/**
 * 有序集合,固定个数
 * Class RedisZaddFixnum.
 */
final class RedisZaddFixnum
{
    public const ORDER_ASC = __LINE__;
    public const ORDER_DESC = __LINE__;
    /** @var  Client */
    private $RedisClient;
    /** @var string 集合的名称 */
    protected $key = '';
    /** @var int 固定个数 */
    protected $fixnum = 20;
    /** @var int 排序方向 */
    protected $orderby = self::ORDER_DESC;
    /** @var RedisConfig */
    protected $config;

    /**
     * @return Client
     */
    public function getRedisClient(): Client
    {
        return $this->RedisClient;
    }


    /**
     * @return int
     */
    public function getOrderby(): int
    {
        return $this->orderby;
    }

    /**
     * @param int $orderby
     *
     * @return RedisZaddFixnum
     */
    public function setOrderby(int $orderby): RedisZaddFixnum
    {
        $this->orderby = $orderby;

        return $this;
    }

    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @param string $key
     *
     * @return RedisZaddFixnum
     */
    public function setKey(string $key): RedisZaddFixnum
    {
        $this->key = $key;

        return $this;
    }

    /**
     * @return int
     */
    public function getFixnum(): int
    {
        return $this->fixnum;
    }

    /**
     * @param int $fixnum
     *
     * @return RedisZaddFixnum
     */
    public function setFixnum(int $fixnum): RedisZaddFixnum
    {
        if ($this->getOrderby() == self::ORDER_ASC) {
            $this->fixnum = $fixnum;
        } else {
            $this->fixnum = -$fixnum - 1;
        }

        return $this;
    }

    /**
     * @return RedisConfig
     */
    public function getConfig(): RedisConfig
    {
        return $this->config;
    }

    /**
     * @param RedisConfig $config
     *
     * @return RedisZaddFixnum
     */
    public function setConfig(RedisConfig $config): RedisZaddFixnum
    {
        $this->config = $config;
        $this->RedisClient = (new RedisClient())->setRedisConfig($this->getConfig());
        return $this;
    }


    /**
     * @param ZaddUnit $ZaddUnit
     *
     * @return RedisZaddFixnum
     */
    public function setZaddUnit(ZaddUnit $ZaddUnit): RedisZaddFixnum
    {
        $this->getRedisClient()->zadd($this->getKey(), $ZaddUnit->getScore(), $ZaddUnit->getName());
        return $this;
    }

    /**
     * @return ZaddUnit[]
     */
    public function __invoke()
    {
        //截断数据,保留分数最大的内容
        if ($this->getOrderby() == self::ORDER_ASC) {
            $this->RedisClient->zremrangebyrank($this->getKey(), $this->getFixnum(), -1);
            $zrevrange = $this->RedisClient->zrange($this->getKey(), 0, -1);
        } else {
            $this->RedisClient->zremrangebyrank($this->getKey(), 0, $this->getFixnum());
            $zrevrange = $this->RedisClient->zrevrange($this->getKey(), 0, -1);
        }
        $ZaddUnit = [];
        foreach ($zrevrange as $item) {
            $score = $this->RedisClient->zscore($this->getKey(), $item);
            $ZaddUnit[] = (new ZaddUnit())->setName($item)->setScore($score);
        }
        return $ZaddUnit;
    }
}
