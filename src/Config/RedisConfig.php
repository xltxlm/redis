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
use xltxlm\resources\Config\ConfigDefine;


/**
 * Redis 配置信息
 * Class RedisConfig.
 */
class RedisConfig extends RedisConfig\RedisConfig_implements implements ConfigDefine
{
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
            //要求链接超时不能超过200ms
            $client->connect($this->getTns(), $this->getPort(), 0.2);
            if ($this->getPassword()) {
                $client->auth($this->getPassword());
            }
        } catch (\Throwable $e) {
            //类的定义
            $filename = (new \ReflectionClass(static::class))->getFileName();
            throw new Exception_Connect_error("配置文件:${filename}," . $this->__Object_toJson() . '|' . $e->__toString());
        }
        return $client;
    }

    /**
     * @return bool
     * @throws \RedisException
     */
    public function Test(): bool
    {
        /** @var \Redis $client */
        $client = $this->__invoke();
        $messageBack = $client->ping();
        return $messageBack;
    }

}
