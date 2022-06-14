<?php

namespace App\Api\Login;

use App\Domain\Wechat\WechatService;
use PhalApi\Api;

class Wechat extends Api
{
    public function getRedirectUrl()
    {
        $url = (new WechatService())->getRedirectUrl();
        println($url);
        die();
    }
}