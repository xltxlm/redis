<?php
/**
 * Created by PhpStorm.
 * User: xialintai
 * Date: 2017/1/5
 * Time: 10:54.
 */

namespace xltxlm\redis;

use xltxlm\redis\Config\RedisConfig;
use xltxlm\redis\Util\ZaddUnit;

/**
 * 有序集合,固定个数
 * Class RedisZaddFixnum.
 */
class RedisZaddFixnum
{
    public const ORDER_ASC = __LINE__;
    public const ORDER_DESC = __LINE__;
    /** @var string 集合的名称 */
    protected $key = '';
    /** @var int 固定个数 */
    protected $fixnum = 20;
    /** @var int 排序方向 */
    protected $orderby = self::ORDER_DESC;
    /** @var RedisConfig */
    protected $config;
    /** @var ZaddUnit[] */
    protected $ZaddUnit;

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

        return $this;
    }

    /**
     * @return ZaddUnit[]
     */
    public function getZaddUnit(): array
    {
        return $this->ZaddUnit;
    }

    /**
     * @param ZaddUnit $ZaddUnit
     *
     * @return RedisZaddFixnum
     */
    public function setZaddUnit(ZaddUnit $ZaddUnit): RedisZaddFixnum
    {
        $this->ZaddUnit[] = $ZaddUnit;

        return $this;
    }

    /**
     * @return ZaddUnit[]
     */
    public function __invoke()
    {
        $Client = (new RedisClient())->setRedisConfig($this->getConfig());
        foreach ($this->getZaddUnit() as $zaddUnit) {
            $Client->zadd($this->getKey(), $zaddUnit->getScore(), $zaddUnit->getName());
        }
        //截断数据,保留分数最大的内容
        if ($this->getOrderby() == self::ORDER_ASC) {
            $Client->zremrangebyrank($this->getKey(), $this->getFixnum(), -1);
        } else {
            $Client->zremrangebyrank($this->getKey(), 0, $this->getFixnum());
        }
        $a = $Client->zrevrange($this->getKey(), 0, -1);
        $ZaddUnit = [];
        foreach ($a as $item) {
            $score = $Client->zscore($this->getKey(), $item);
            $ZaddUnit[] = (new ZaddUnit())->setName($item)->setScore($score);
        }
        return $ZaddUnit;
    }
}
