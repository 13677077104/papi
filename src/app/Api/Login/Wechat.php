<?php

namespace App\Api\Login;

use App\Domain\Wechat\WechatService;
use EasyWeChat\Factory;
use PhalApi\Api;

class Wechat extends Api
{
    public function getRules(): array
    {
        return array(
            'getUserInfo' => array(
                'code' => array('name' => 'code', 'default' => '', 'desc' => 'code'),
            ),
        );
    }

    // step 1 获取跳转微信授权接口
    public function getRedirectUrl(): array
    {
        $url = (new WechatService())->getRedirectUrl();
        return [
            'redirect_url' => $url,
        ];
    }

    /**
     * @desc step 2 授权成功，微信跳转回来接口
     */
    public function callback()
    {
        $config = config('app.wechat_config');
        $oauth = Factory::officialAccount($config)->oauth;

        // 获取 OAuth 授权结果用户信息
        $user = $oauth->user();
        logData($user);
        header('location:/test.html');

        /*
        if ($errCode) {
            throw new CustomException($content['errmsg']);
        }
        $openid = $content['openid'];
        $accessToken = $content['access_token'];
        $expiresIn = time() + $content['expires_in'];
        $srv = new UserService();
        $id = $srv->createData([
            'openid' => $openid,
        ]);
        return [
            'user_id' => $id,
            'access_token' => $accessToken,
            'expires_in' => $expiresIn,
            'openid' => $openid,
        ];*/
    }

}