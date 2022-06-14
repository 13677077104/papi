<?php

namespace App\Api;

use App\Domain\Wechat\Wechat;
use EasyWeChat\Factory;
use PhalApi\Api;


/**
 * 默认接口服务类
 * @author: dogstar <chanzonghuang@gmail.com> 2014-10-04
 */
class Site extends Api
{
    public function getRules(): array
    {
        return array(
            'index' => array(
                'username' => array('name' => 'username', 'default' => 'PhalApi', 'desc' => '用户名'),
            ),
        );
    }

    /**
     * 默认接口服务 <span class="ui label green small">默认</span>
     * @desc 默认接口服务，当未指定接口服务时执行此接口服务
     * @returnList string title 标题
     * @returnList string content 内容
     * @returnList string version 版本，格式：X.X.X
     * @returnList int time 当前时间戳
     * @exception 400 非法请求，参数传递错误
     */
    public function index()
    {

        $app = new Wechat();
        $app->getToken();

        return array(
            'title' => 'Hello ----' . $this->username,
            'version' => PHALAPI_VERSION,
            'time' => $_SERVER['REQUEST_TIME'],
        );
    }
}
