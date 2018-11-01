<?php

namespace xltxlm\redis\Exception\Redis_LockKey;


/**
 * 锁住key失败;
 */
class LockFall_Exception extends \Exception
{
    use LockFall_Exception\LockFall_Exception_implements;


}