<?php

namespace App\Domain\Wechat;

use EasyWeChat\Factory;



class WechatService
{
    private $app;
    public function __construct()
    {
        $config = config('app.wechat_config');
        $this->app = Factory::officialAccount($config);
    }


    public function getRedirectUrl(): ?string
    {
        return $this->app->oauth->scopes(['snsapi_userinfo'])->redirect();
    }
}