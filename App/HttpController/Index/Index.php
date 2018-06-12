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
use App\Model\Line as LineM;
use think\db\exception\DbException;

class Index extends ViewController
{
    function index()
    {
        $wx = new WechatIndexController('getJssdkSignature', $this->request(), $this->response());
        $jssdk = $wx->getJssdkSignature(false);
        $jssdk_arr = json_decode($jssdk, true);

        $lineM = new LineM;
        //$lst = LineM::order('id desc')->limit(10)->select();
        try {
            $lst = $lineM->order('id desc')->paginate();
        } catch (DbException $e) {
        }

        $this->view->assign([
            'lst' => $lst,
            'jssdk_arr' => $jssdk_arr
        ]);
        $this->fetch('Index/Index/index');

    }

    function index2()
    {
//        $wx = new WechatIndexController('getJssdkSignature', $this->request(), $this->response());
//        $jssdk = $wx->getJssdkSignature(false);
//
//        //真实地址
//        $ip = ServerManager::getInstance()->getServer()->connection_info($this->request()->getSwooleRequest()->fd);
//
//        //header 地址，例如经过nginx proxy后
//        $ip2 = $this->request()->getHeaders();
//
//        $uri = $this->getActionName();
//        $this->view->assign([
//            'jssdk' => $jssdk,
//            ]);
//        $this->fetch('Index/Index/index');

    }

}