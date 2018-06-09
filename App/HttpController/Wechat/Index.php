<?php
/**
 * Created by PhpStorm.
 * User: encir
 * Date: 2018/6/9
 * Time: 13:53
 */

namespace App\HttpController\Wechat;


use EasySwoole\Config;
use EasySwoole\Core\Component\Logger;
use EasySwoole\Core\Http\AbstractInterface\Controller;
use EasySwoole\Core\Http\Request;
use EasySwoole\Core\Http\Response;
use EasyWeChat\Factory;
use EasyWeChat\Kernel\Exceptions\InvalidArgumentException;

class Index extends Controller
{
    private $app;
    private $message;

    function index()
    {
        // TODO: Implement index() method.
    }

    public function __construct(string $actionName, Request $request, Response $response)
    {
        $config = Config::getInstance()->getConf('wechat');
        var_dump($config);

        $this->app = Factory::officialAccount($config);

        $this->app->request = \App\Utils\Request::createFromGlobals();

        parent::__construct($actionName, $request, $response);
    }

    public function check()
    {
        $app = $this->app;

        try {
            $app->server->push(function ($message) {

                $this->message = $message;
                Logger::getInstance()->log(json_encode($message), 'debug');

                switch ($message['MsgType']) {
                    case 'event':
                        return '收到事件消息';
                        break;
                    case 'text':
                        return 'text';
                        break;
                    case 'image':
                        return '收到图片消息';
                        break;
                    case 'voice':
                        return '收到语音消息';
                        break;
                    case 'video':
                        return '收到视频消息';
                        break;
                    case 'location':
                        return '收到坐标消息';
                        break;
                    case 'link':
                        return '收到链接消息';
                        break;
                    case 'file':
                        return '收到文件消息';
                    // ... 其它消息
                    default:
                        return '收到其它消息';
                        break;
                }

            });
        } catch (InvalidArgumentException $e) {
        }

        $response = $app->server->serve();

        $this->response()->write($response->getContent());
    }

    public function oauth_callback()
    {

    }
}