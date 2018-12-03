<?php
namespace xltxlm\redis\Config\RedisConfig;

use \xltxlm\resources\Config\ConfigDefineTrait;
use \xltxlm\classinfo\Features\__Object_toJson;

/**
 * 服务器配置;
*/
abstract class RedisConfig_implements
{
    use ConfigDefineTrait;
    use __Object_toJson;

    /**
    *  测试服务是否正常;
    *  @return :bool;
    */
    abstract public function Test():bool;
    /**
    *  创建新链接;
    *  @return ;
    */
    abstract public function NewConnect();
}
