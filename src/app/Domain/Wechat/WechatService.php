<?php

namespace App\Domain\Wechat;

use EasyWeChat\Factory;



class WechatService
{
    private $app;
    public function __construct()
    {
        $config = config('app.wechat_config');
        $config += [
            'oauth' => [
                'scopes'   => ['snsapi_userinfo'],
                'callback' => '/code',
            ]
        ];

        $this->app = Factory::officialAccount($config);
    }


}