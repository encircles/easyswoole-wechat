<?php
/**
 * Created by PhpStorm.
 * User: encir
 * Date: 2018/6/9
 * Time: 0:40
 */

namespace App\HttpController\Index;

use App\ViewController;
use EasySwoole\Core\Http\AbstractInterface\Controller;
use EasySwoole\Core\Swoole\ServerManager;
use App\HttpController\Wechat\Index as WechatIndexController;

class Index extends ViewController
{
    function index()
    {
        $wx = new WechatIndexController('getJssdkSignature', $this->request(), $this->response());
        $jssdk = $wx->getJssdkSignature(true);
        $jssdk_arr = json_decode($jssdk, true);
        $accessToken = $wx->getAccessToken();
        //真实地址
        $ip = ServerManager::getInstance()->getServer()->connection_info($this->request()->getSwooleRequest()->fd);

        //header 地址，例如经过nginx proxy后
        $ip2 = $this->request()->getHeaders();

        $uri = $this->getActionName();
        $this->view->assign([
            'jssdk_arr' => $jssdk_arr,
            'accessToken' => $accessToken,
            'uri' => $uri,
            'ip' => $ip,
            'ip2' => $ip2,
            'jssdk' => $jssdk
            ]);
        // TODO: Implement index() method.
        $this->fetch('Index/Index/index');

    }

    public function index2()
    {
        $this->response()->write('index2');
        //真实地址
        $ip = ServerManager::getInstance()->getServer()->connection_info($this->request()->getSwooleRequest()->fd);

        //header 地址，例如经过nginx proxy后
        $ip2 = $this->request()->getHeaders();

        $uri = $this->getActionName();
        $this->view->assign([
            'uri' => $uri,
            'ip' => $ip,
            'ip2' => $ip2
        ]);
        // TODO: Implement index() method.
        $this->fetch('Index/Index/index');
    }
}