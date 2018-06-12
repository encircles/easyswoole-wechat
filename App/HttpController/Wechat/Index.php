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
use EasyWeChat\Kernel\Exceptions\InvalidConfigException;

class Index extends Controller
{
    private $app;
    private $message;

    function index()
    {
        // TODO: Implement index() method.
    }

    /**
     * @param bool $debug 调试模式
     */
    public function getJssdkSignature($debug = false)
    {
        //JS-SDK
        try {
            //$jssdk_signature = $this->app->jssdk->buildConfig(array('onMenuShareQQ', 'onMenuShareWeibo', 'onMenuShareTimeline', 'onMenuShareAppMessage', 'chooseWXPay'), $debug);
            $jssdk_signature = $this->app->jssdk->buildConfig(array('onMenuShareQQ', 'onMenuShareWeibo', 'onMenuShareTimeline', 'onMenuShareAppMessage'), $debug);
            Logger::getInstance()->log(json_encode($this->app->jssdk->getTicket()), 'debug');
            Logger::getInstance()->log(json_encode($this->app->jssdk->getUrl()), 'debug');
        } catch (InvalidConfigException $e) {
        } catch (\Psr\SimpleCache\InvalidArgumentException $e) {
        }
        return $jssdk_signature;
    }

    public function getAccessToken()
    {
        // 获取 access token 实例
        $accessToken = $this->app->access_token;
        $token = $accessToken->getToken(); // token 数组  token['access_token'] 字符串
        return $token;
    }

    public function test()
    {
        $this->response()->write('wechat/index/test');
    }

    public function index2()
    {
        $this->response()->write('wechat/index2');
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
            $app->server->push(function ($message) use($app) {

                $this->message = $message;
                Logger::getInstance()->log(json_encode($message), 'debug');

                switch ($message['MsgType']) {
                    case 'event':
                        return '收到事件消息';
                        break;
                    case 'text':
                        $user = $app->user->get($this->message['FromUserName']);
                        $res = $this->checkText($this->message['Content']);
                        return $res;
                        break;
                    case 'image':
                        return '收到图片消息';
                        break;
                    case 'voice':
                        //return '收到语音消息';
                        return json_encode($this->message);
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

    public function checkText($value)
    {
        switch ($value) {
            case '1':
                return '您输入了数字1';
            case '2':
                return '您输入的数字2';
            default:
                return 'Default';
        }
    }

    public function oauth_callback()
    {

    }
}