<?php

namespace Api\Login;

use App\Api\Login\Wechat;
use PHPUnit\Framework\TestCase;

class WechatTest extends TestCase
{

    public function testGetRedirectUrl()
    {
        $ctl = new Wechat();
        $ret = $ctl->getRedirectUrl();
    }
}
