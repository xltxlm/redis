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
class RedisConnectLog extends BasicLog
{

    /**
     * RedisConnect constructor.
     */
    public function __construct($message)
    {
        parent::__construct($message);
        $this->setReource(RedisClient::class);
    }
}
