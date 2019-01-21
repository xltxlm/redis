<?php
namespace xltxlm\redis\Config\RedisConfig;

use \xltxlm\resources\Config\ConfigDefineTrait;
use \xltxlm\classinfo\Features\__Object_toJson;

/**
 * :类;
 * 服务器配置;
*/
abstract class RedisConfig_implements
{
    use ConfigDefineTrait;
    use __Object_toJson;

    /* @var \xltxlm\logger\Resource_define\Resource_define_redis  链接日志,延迟到功能注销之后才执行,否则因为日志写入之前需要链接redis,造成死循环 */
    protected $connectlog;

    /**
    * @return \xltxlm\logger\Resource_define\Resource_define_redis;
    */
    protected function getconnectlog():\xltxlm\logger\Resource_define\Resource_define_redis
    {
        return $this->connectlog;
    }

    /**
    * @param \xltxlm\logger\Resource_define\Resource_define_redis $connectlog;
    * @return $this
    */
    protected function setconnectlog(\xltxlm\logger\Resource_define\Resource_define_redis $connectlog)
    {
        $this->connectlog = $connectlog;
        return $this;
    }

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
