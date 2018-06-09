<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018/1/9
 * Time: 下午1:04
 */

namespace EasySwoole;

use App\Process\Inotify;
use App\Utils\Context;
use \EasySwoole\Core\AbstractInterface\EventInterface;
use EasySwoole\Core\Swoole\Process\ProcessManager;
use \EasySwoole\Core\Swoole\ServerManager;
use \EasySwoole\Core\Swoole\EventRegister;
use \EasySwoole\Core\Http\Request;
use \EasySwoole\Core\Http\Response;

Class EasySwooleEvent implements EventInterface {

    public static function frameInitialize(): void
    {
        // TODO: Implement frameInitialize() method.
        date_default_timezone_set('Asia/Shanghai');
    }

    public static function mainServerCreate(ServerManager $server,EventRegister $register): void
    {
        // TODO: Implement mainServerCreate() method.
        ProcessManager::getInstance()->addProcess('autoReload', Inotify::class);
    }

    public static function onRequest(Request $request,Response $response): void
    {
        // TODO: Implement onRequest() method.
        $req = $request->getSwooleRequest();
        Context::set($req);

        // TODO: Implement onRequest() method.

        if (!empty($_SERVER)) {
            unset($_SERVER);
        }
        if (isset($req->server)) {
            foreach ($req->server as $k => $v) {
                $_SERVER[strtoupper($k)] = $v;
            }
        }
        if (isset($req->header)) {
            foreach ($req->header as $k => $v) {
                $_SERVER[strtoupper($k)] = $v;
            }
        }

        if (!empty($_GET)) {
            unset($_GET);
        }
        if (isset($req->get)) {
            foreach ($req->get as $k => $v) {
                $_GET[$k] = $v;
            }
        }

        if (!empty($_POST)) {
            unset($_POST);
        }
        if (isset($req->post)) {
            foreach ($req->post as $k => $v) {
                $_POST[$k] = $v;
            }
        }
    }

    public static function afterAction(Request $request,Response $response): void
    {
        // TODO: Implement afterAction() method.
    }
}