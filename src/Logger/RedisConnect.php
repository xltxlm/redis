<?php

namespace xltxlm\redis\Logger;

use xltxlm\logger\Log\BasicLog;
use xltxlm\redis\RedisClient;

/**
 * Created by PhpStorm.
 * User: xialintai
 * Date: 2017/2/16
 * Time: 10:14.
 */
class RedisConnect extends BasicLog
{

    /**
     * RedisConnect constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->setReource(RedisClient::class);
    }
}
