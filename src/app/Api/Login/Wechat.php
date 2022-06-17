<?php

namespace App\Api\Login;

use App\Common\Exception\CustomException;
use App\Common\Redis;
use App\Common\RedisService;
use App\Domain\User\UserService;
use EasyWeChat\Factory;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
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

    // step 1
    public function getRedirectUrl(): array
    {
        $uri = 'https://open.weixin.qq.com/connect/oauth2/authorize';
        $redirect_uri = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/user/info';
        $queryParams = [
            'appid' => config('app.wechat_config.app_id'),
            'redirect_uri' => $redirect_uri,
            'response_type' => 'code',
            'scope' => 'snsapi_base',
        ];

        $url = $uri . '?' . http_build_query($queryParams) . '#wechat_redirect';
        return [
            'redirect_url' => $url,
        ];
    }

    /**
     * @desc step 2 get access_token & openid
     * @throws CustomException
     */
    public function getUserInfo(): array
    {
        $code = $this->code;
        $uri = 'https://api.weixin.qq.com/sns/oauth2/access_token';
        $queryParams = [
            'appid' => config('app.wechat_config.app_id'),
            'secret' => config('app.wechat_config.secret'),
            'code' => $code,
            'grant_type' => 'authorization_code',
        ];

        $client = new Client();
        try {
            $res = $client->request('GET', $uri, ['query' => $queryParams]);
        } catch (GuzzleException $e) {
            throw new CustomException($e->getMessage());
        }
        $content = $res->getBody()->getContents();
        $content = json_decode($content, true);
        $errCode = $content['errcode'] ?? null;
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
        ];
    }

// -------------------------------------------------------------------------
    // test
    public function getUserId(): array
    {
        $defaultConfig = config('app.wechat_config');
        $defaultConfig = array_merge($defaultConfig, [
            'oauth' => [
                'scopes'   => ['snsapi_base'],
                'callback' => '/user/bb',
            ]
        ]);

        $app = Factory::officialAccount($defaultConfig);
        $oauth = $app->oauth;

        $key = 'who';
        $redis = RedisService::getInstance();

        if (!$redis->get($key)) {
            $oauth->redirect()->send();
        }
        return [
            'user_id' => 1,
        ];
    }

    public function bb()
    {
        ini_set('display_errors', 1);
        $config = [
            'oauth' => [
                'scopes'   => ['snsapi_base'],
                'callback' => '/oauth_callback',
            ],
        ];
        $app = Factory::officialAccount($config);
        $oauth = $app->oauth;

        // 获取 OAuth 授权结果用户信息
        $user = $oauth->user();
        logData($user->toArray());
        header('location:/user/id');
    }

}