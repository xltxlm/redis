<?php
/**
 * Created by PhpStorm.
 * User: xialintai
 * Date: 2017/1/5
 * Time: 10:54.
 */

namespace xltxlm\redis;

use xltxlm\redis\Config\RedisConfig;
use xltxlm\logger\Operation\Action\RedisRunLog;
use xltxlm\redis\Util\ZaddUnit;

/**
 * 有序集合,固定个数
 * Class RedisZaddFixnum.
 */
final class RedisZaddFixnum
{
    public const ORDER_ASC = __LINE__;
    public const ORDER_DESC = __LINE__;
    /** @var  \Redis */
    private $RedisClient;
    /** @var string 集合的名称 */
    protected $key = '';
    /** @var int 固定个数 */
    protected $fixnum = 20;
    /** @var int 排序方向 */
    protected $orderby = self::ORDER_DESC;
    /** @var RedisConfig */
    protected $redisConfig;

    /**
     * @return \Redis
     */
    public function getRedisClient() :\Redis
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
    public function getRedisConfig(): RedisConfig
    {
        return $this->config;
    }

    /**
     * @param RedisConfig $config
     *
     * @return RedisZaddFixnum
     */
    public function setRedisConfig(RedisConfig $redisConfig): RedisZaddFixnum
    {
        $this->redisConfig = $redisConfig;
        /** @var \Redis RedisClient */
        $this->RedisClient = $redisConfig->__invoke();
        return $this;
    }


    /**
     * 追加单元队列
     * @param ZaddUnit $ZaddUnit
     *
     * @return RedisZaddFixnum
     */
    public function setZaddUnit(ZaddUnit $ZaddUnit): RedisZaddFixnum
    {
        $redisRunLog = new RedisRunLog($this);
        $this->getRedisClient()->zadd($this->getKey(), $ZaddUnit->getScore(), $ZaddUnit->getName());
        $redisRunLog
            ->setMethod(__METHOD__)
            ->__invoke();
        return $this;
    }

    /**
     * 删除有序集合队列
     */
    public function clear()
    {
        $this->getRedisClient()->del($this->getKey());
    }

    /**
     * @return ZaddUnit[]
     */
    public function __invoke()
    {
        $redisRunLog = new RedisRunLog($this);
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
        $redisRunLog
            ->setMethod(__METHOD__)
            ->__invoke();
        return $ZaddUnit;
    }
}
