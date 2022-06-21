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

    public function getRedirectUrl($scopes = 'snsapi_base'): string
    {
        $callback = '/oauth/callback';
        $config = array_merge($this->config, [
            'oauth' => [
                'scopes' => [$scopes],
                'callback' => $callback,
            ],
        ]);
        $oauth = Factory::officialAccount($config)->oauth;
        return $oauth->redirect()->getTargetUrl();
    }

}