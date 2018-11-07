<?php
namespace xltxlm\redis\Features\SpeedLimiter;

/**
 * 限速光卡;
*/
Trait SpeedLimiter_implements
{



    /* @var \xltxlm\redis\Config\RedisConfig  Redis配置 */
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

    /* @var string  要限速的key */
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

    /* @var int  限速周期 */
        protected $cycletime = 0;
    


    /**
     * @return int;
     */
    public function getcycletime():int    {
        return $this->cycletime;
    }




    /**
     * @param int $cycletime;
     * @return $this
     */
    public function setcycletime(int $cycletime)
    {
        $this->cycletime = $cycletime;
        return $this;
    }

    /* @var int  周期内最大速率 */
        protected $maxtimes = 0;
    


    /**
     * @return int;
     */
    public function getmaxtimes():int    {
        return $this->maxtimes;
    }




    /**
     * @param int $maxtimes;
     * @return $this
     */
    public function setmaxtimes(int $maxtimes)
    {
        $this->maxtimes = $maxtimes;
        return $this;
    }

    /* @var bool  超速了,抛出异常 */
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

    /* @var string  真正存储的key,带上时间概念的 */
        protected $realkey = '';
    


    /**
     * @return string;
     */
    public function getrealkey():string    {
        return $this->realkey;
    }




    /**
     * @param string $realkey;
     * @return $this
     */
    public function setrealkey(string $realkey)
    {
        $this->realkey = $realkey;
        return $this;
    }

    /**
     *   实现通用的光卡逻辑;
     *   @return :bool;
    */
    abstract public function __invoke():bool;

}