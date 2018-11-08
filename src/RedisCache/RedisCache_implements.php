<?php
namespace xltxlm\redis\RedisCache;

/**
 * kv缓存逻辑.一旦存储了,过期时间前不会再穿透;
*/
abstract class RedisCache_implements
{



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

    /* @var int  过期时间,默认是一天 */
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

    /* @var bool  用于判断是否已经命中缓存了 */
        protected $cached = false;
    


    /**
     * @return bool;
     */
    public function getcached():bool    {
        return $this->cached;
    }


    public function iscached():bool    {
            return $this->getcached();
    }
    



    /**
     * @param bool $cached;
     * @return $this
     */
    public function setcached(bool $cached)
    {
        $this->cached = $cached;
        return $this;
    }

    /* @var void  需要缓存起来的值 */
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

}