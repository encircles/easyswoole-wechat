<?php
namespace App\Utils;


use EasySwoole\Core\Component\Logger;

class Context
{
    public static $req;

    public static function set(\swoole_http_request $request)
    {
        self::$req = $request;
    }

    public static function get()
    {
        return self::$req;
    }
}