<?php

namespace xltxlm\redis\Exception\Config;

use xltxlm\exception\Exception;

/**
 * 链接补上redis服务的时候,报错信息包含配置信息;
 */
class Exception_Connect_error extends Exception
{
    use Exception_Connect_error\Exception_Connect_error_implements;
}
