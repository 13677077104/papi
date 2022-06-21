<?php

namespace App\Domain\Wechat;

use EasyWeChat\Factory;


class WechatService
{
    private $config;

    public function __construct()
    {
        $this->config = config('app.wechat_config');
    }

    public function getRedirectUrl(): string
    {
        $callback = '/oauth/callback';
        $config = array_merge($this->config, [
            'oauth' => [
                'scopes' => ['snsapi_base'],
                'callback' => $callback,
            ],
        ]);
        $oauth = Factory::officialAccount($config)->oauth;
        return $oauth->redirect()->getTargetUrl();
    }

}