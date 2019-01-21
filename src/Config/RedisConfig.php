<?php
/**
 * Created by PhpStorm.
 * User: xialintai
 * Date: 2016/12/26
 * Time: 17:06.
 */

namespace xltxlm\redis\Config;

use xltxlm\logger\Resource_define\Resource_define_redis;
use xltxlm\redis\Exception\Config\Exception_Connect_error;


/**
 * Redis 配置信息
 * Class RedisConfig.
 */
class RedisConfig extends RedisConfig\RedisConfig_implements implements \xltxlm\resources\Config\ConfigDefine
{
    /**
     * 返回自增id序列
     * @return  string
     */
    public function snownum()
    {
        $client = $this->__invoke();
        $seqnum = $client->rPop('snownum_list');
        $取不出序号 = !$seqnum;
        if ($取不出序号) {
            throw new \Exception("{$this->getTns()}:{$this->getPort()}|序号分发器取不出自增id: $seqnum");
        }
        return $seqnum;
    }

    /**
     * @return \Redis 返回redis对象
     */
    public function NewConnect(): \Redis
    {
        $client = new \Redis();
        try {
            try {
                $this->connectlog = (new Resource_define_redis())
                    ->settns($this->getTns())
                    ->setuser($this->getPassword())
                    ->setport($this->getPort());
            } catch (\Exception $e) {
            }

            $client->connect($this->getTns(), $this->getPort());
            if ($this->getPassword()) {
                $client->auth($this->getPassword());
            }
        } catch (\Throwable $e) {
            throw new Exception_Connect_error($this->__Object_toJson() . '|' . $e->__toString());
        }
        return $client;
    }

    public function Test(): bool
    {
        $client = $this->__invoke();
        $messageBack = $client->ping();
        return $messageBack;
    }

}
