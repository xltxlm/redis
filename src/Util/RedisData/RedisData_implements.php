<?php
namespace xltxlm\redis\Util\RedisData;

/**
 * redis缓存设置的数据结构;
*/
abstract class RedisData_implements
{



    /* @var string  创建时间 */
        protected $addTime = '';
    


    /**
     * @return string;
     */
    public function getaddTime():string    {
        return $this->addTime;
    }




    /**
     * @param string $addTime;
     * @return $this
     */
    public function setaddTime(string $addTime)
    {
        $this->addTime = $addTime;
        return $this;
    }

    /* @var void  缓存的内容,可以是对象类型 */
        protected $data;
    


    /**
     * @return void;
     */
    public function getdata()    {
        return $this->data;
    }




    /**
     * @param  $data;
     * @return $this
     */
    public function setdata( $data)
    {
        $this->data = $data;
        return $this;
    }

    /* @var string  触发的客户端ip */
        protected $ip = '';
    


    /**
     * @return string;
     */
    public function getip():string    {
        return $this->ip;
    }




    /**
     * @param string $ip;
     * @return $this
     */
    public function setip(string $ip)
    {
        $this->ip = $ip;
        return $this;
    }

}