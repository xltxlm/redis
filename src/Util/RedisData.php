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
class RedisData extends RedisData\RedisData_implements
{

    /**
     * RedisData constructor.
     */
    public function __construct()
    {
        $this->setAddTime(date('Y-m-d H:i:s'));
        $this->setip((string)$_SERVER['REMOTE_ADDR']);
    }

}
