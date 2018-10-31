<?php
/**
 * Created by PhpStorm.
 * User: xialintai
 * Date: 2016/12/26
 * Time: 17:06.
 */

namespace xltxlm\redis\Config;

use xltxlm\resources\Config\ConfigDefineTrait;


/**
 * @method \Redis __invoke()
 * Redis 配置信息
 * Class RedisConfig.
 */
class RedisConfig extends RedisConfig\RedisConfig_implements implements \xltxlm\resources\Config\ConfigDefine
{
    use ConfigDefineTrait;

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
        $client->connect($this->getTns(), $this->getPort());
        if ($this->getPassword()) {
            $client->auth($this->getPassword());
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
