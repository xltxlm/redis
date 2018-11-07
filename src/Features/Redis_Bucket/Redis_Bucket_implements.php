<?php
namespace xltxlm\redis\Features\Redis_Bucket;

/**
 * 限制每天的额度;
*/
Trait Redis_Bucket_implements
{



    /* @var \xltxlm\redis\Config\RedisConfig   */
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

    /* @var int  最大存储元素个数 */
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

    /* @var void  追加新元素 */
        protected $value;
    


    /**
     * @return void;
     */
    public function getvalue()    {
        return $this->value;
    }




    /**
     * @param  $value;
     * @return $this
     */
    public function setvalue( $value)
    {
        $this->value = $value;
        return $this;
    }

    /* @var int  过期时间 */
        protected $expire = 0;
    


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

    /* @var string  正在缓存的key */
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

    /* @var bool  超速之后是否抛出异常 */
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

    /* @var string   */
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

    /**
     *   确认是否已经满了;
     *   @return :bool;
    */
    abstract public function __invoke():bool;

}