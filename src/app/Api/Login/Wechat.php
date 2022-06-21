<?php

namespace App\Api\Login;

use App\Common\Exception\CustomException;
use App\Domain\User\UserService;
use App\Domain\Wechat\WechatService;
use EasyWeChat\Factory;
use Exception;
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
     * @throws CustomException
     */
    public function callback()
    {
        $config = config('app.wechat_config');
        try {// 获取 OAuth 授权结果用户信息
            $oauth = Factory::officialAccount($config)->oauth;
            $user = $oauth->user();
            $openid = $user->getId();
            $srv = new UserService();
            $id = $srv->createData([
                'openid' => $openid,
            ]);
        } catch (Exception $e) {
            throw new CustomException($e->getMessage());
        }
        $queryString = http_build_query([
            'user_id' => $id,
            'openid' => $openid,
        ]);
        header('location:/test.html?' . $queryString);
    }

}