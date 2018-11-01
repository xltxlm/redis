<?php
namespace xltxlm\redis\Exception\Redis_LockKey\LockFall_Exception;

/**
 * 锁住key失败;
*/
Trait LockFall_Exception_implements
{



    /* @var \xltxlm\redis\Config\RedisConfig  */
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

    /* @var \xltxlm\redis\Features\Redis_LockKey  */
        protected $Redis_LockKey;
    


    /**
     * @return \xltxlm\redis\Features\Redis_LockKey;
     */
    public function getRedis_LockKey():\xltxlm\redis\Features\Redis_LockKey    {
        return $this->Redis_LockKey;
    }




    /**
     * @param \xltxlm\redis\Features\Redis_LockKey $Redis_LockKey;
     * @return $this
     */
    public function setRedis_LockKey(\xltxlm\redis\Features\Redis_LockKey $Redis_LockKey)
    {
        $this->Redis_LockKey = $Redis_LockKey;
        return $this;
    }

}