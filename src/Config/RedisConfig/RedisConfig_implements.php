<?php
namespace xltxlm\redis\Config\RedisConfig;

use \xltxlm\resources\Config\ConfigDefineTrait;
/**
 * 服务器配置;
*/
abstract class RedisConfig_implements
{

    use ConfigDefineTrait;


    /**
     *   测试服务是否正常;
     *   @return :bool;
    */
    abstract public function Test():bool;

}