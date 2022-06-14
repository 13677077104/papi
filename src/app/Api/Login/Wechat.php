<?php

namespace App\Api\Login;

use PhalApi\Api;

class Wechat extends Api
{
    public function getRedirectUrl()
    {
        $uri = 'https://open.weixin.qq.com/connect/oauth2/authorize';
        $redirect_uri = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . '/code';
        $queryParams = [
            'appid' => config('app.wechat_config.app_id'),
            'redirect_uri' => urlencode($redirect_uri),
            'response_type' => 'code',
            'scope' => 'snsapi_base',
        ];

        $url = $uri . '?' . http_build_query($queryParams) . '#wechat_redirect';
        return [
            'redirect_url' => $url,
        ];
    }
}