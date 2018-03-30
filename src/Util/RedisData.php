<?php
/**
 * Created by PhpStorm.
 * User: xialintai
 * Date: 2016/12/27
 * Time: 10:17.
 */

namespace xltxlm\redis\Util;

/**
 * 缓存存储在redis里面的数据,把缓存的数据再包一层防止空查询
 * 空查询: SQL正确,但是肯定没内容
 * Class RedisData.
 */
final class RedisData
{
    /** @var string 缓存的时间 */
    protected $addTime = '';
    /** @var mixed 缓存的内容 */
    protected $data;

    /**
     * RedisData constructor.
     */
    public function __construct()
    {
        $this->setAddTime(date('Y-m-d H:i:s'));
    }


    /**
     * @return string
     */
    public function getAddTime(): string
    {
        return $this->addTime;
    }

    /**
     * @param string $addTime
     *
     * @return RedisData
     */
    public function setAddTime(string $addTime): RedisData
    {
        $this->addTime = $addTime;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     *
     * @return RedisData
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }
}
