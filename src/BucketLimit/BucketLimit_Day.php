<?php

namespace xltxlm\redis\BucketLimit;


/**
 * 每日限量;
 */
class BucketLimit_Day extends BucketLimit_Day\BucketLimit_Day_implements
{
    public function getexpire(): int
    {
        $leftseconds = strtotime('tomorrow') - strtotime('today');
        return $leftseconds;
    }

    public function getrealkey(): string
    {
        $this->realkey = $this->key . '-' . date('Ymd');
        return $this->realkey;
    }


}