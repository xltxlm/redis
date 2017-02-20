<?php
/**
 * Created by PhpStorm.
 * User: xialintai
 * Date: 2017/2/20
 * Time: 10:24
 */

namespace xltxlm\redis\Logger;

/**
 * 查询日志
 * Class RedisRunLog
 * @package xltxlm\redis\Logger
 */
class RedisRunLog extends RedisConnect
{
    protected $method = "";

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @param string $method
     * @return RedisRunLog
     */
    public function setMethod(string $method): RedisRunLog
    {
        $this->method = $method;
        return $this;
    }


}