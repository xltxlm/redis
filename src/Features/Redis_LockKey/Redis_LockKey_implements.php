<?php
namespace xltxlm\redis\Features\Redis_LockKey;

/**
 * 锁定函数;
*/
abstract class Redis_LockKey_implements
{



    /* @var string 锁定的key */
        protected $key = '';
    


    /**
     * @return string;
     */
    public function getkey():string    {
        return $this->key;
    }




    /**
     * @param string $key;
     * @return $this
     */
    public function setkey(string $key)
    {
        $this->key = $key;
        return $this;
    }

    /* @var int 超时时间 */
        protected $expire = 86400;
    


    /**
     * @return int;
     */
    public function getexpire():int    {
        return $this->expire;
    }




    /**
     * @param int $expire;
     * @return $this
     */
    public function setexpire(int $expire)
    {
        $this->expire = $expire;
        return $this;
    }

    /* @var \xltxlm\redis\Config\RedisConfig 服务器配置 */
        protected $RedisConfig;
    


    /**
     * @return \xltxlm\redis\Config\RedisConfig;
     */
    public function getRedisConfig():\xltxlm\redis\Config\RedisConfig    {
        return $this->RedisConfig;
    }




    /**
     * @param \xltxlm\redis\Config\RedisConfig $RedisConfig;
     * @return $this
     */
    public function setRedisConfig(\xltxlm\redis\Config\RedisConfig $RedisConfig)
    {
        $this->RedisConfig = $RedisConfig;
        return $this;
    }

    /* @var string 需要存储的值,默认是当前时间 */
        protected $value = '';
    


    /**
     * @return string;
     */
    public function getvalue():string    {
        return $this->value;
    }




    /**
     * @param string $value;
     * @return $this
     */
    public function setvalue(string $value)
    {
        $this->value = $value;
        return $this;
    }

    /* @var int 如果一次锁不住,希望卡住坚持的秒数 */
        protected $Try_Wait_Second = 0;
    


    /**
     * @return int;
     */
    public function getTry_Wait_Second():int    {
        return $this->Try_Wait_Second;
    }




    /**
     * @param int $Try_Wait_Second;
     * @return $this
     */
    public function setTry_Wait_Second(int $Try_Wait_Second)
    {
        $this->Try_Wait_Second = $Try_Wait_Second;
        return $this;
    }

    /* @var bool 锁定失败的时候,抛出异常 */
        protected $Exception_on_LockFail = false;
    


    /**
     * @return bool;
     */
    public function getException_on_LockFail():bool    {
        return $this->Exception_on_LockFail;
    }




    /**
     * @param bool $Exception_on_LockFail;
     * @return $this
     */
    public function setException_on_LockFail(bool $Exception_on_LockFail)
    {
        $this->Exception_on_LockFail = $Exception_on_LockFail;
        return $this;
    }

    /**
     *   检测是否已经锁住了;
     *   @return :bool;
    */
    abstract public function __invoke():bool;

    /**
     *   执行的是事务的时候,还需要主动释放掉key;
     *   @return :bool;
    */
    abstract public function Free():bool;

}