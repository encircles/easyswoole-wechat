<?php
/**
 * Created by PhpStorm.
 * User: encir
 * Date: 2018/6/9
 * Time: 23:40
 */

namespace App\HttpController\Wechat;


use EasySwoole\Core\Http\AbstractInterface\Controller;

class Test extends Controller
{

    function index()
    {
        // TODO: Implement index() method.
    }

    public function index2()
    {
        $this->response()->write('wechat/test/index2');
    }
}