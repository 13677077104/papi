<?php

namespace App\Api\Login;

use App\Common\Exception\InvalidArgumentException;
use App\Common\JwtService;
use App\Domain\User\UserService;
use EasyWeChat\Factory;
use EasyWeChat\Kernel\Exceptions\InvalidConfigException;
use PhalApi\Api;

/**
 * 小程序的登录授权
 */
class Applet extends Api
{
    public function getRules(): array
    {
        return array(
            'getAccessToken' => array(
                'code' => array('name' => 'code', 'require' => true, 'desc' => 'code'),
            ),
        );
    }

    /**
     * @throws InvalidArgumentException
     */
    public function getAccessToken(): array
    {
        $code = $this->code;
        $config = config('app.applet_config');
        $app = Factory::miniProgram($config);
        try {
            $res = $app->auth->session($code);
            $errcode = $res['errcode'] ?? null;
            if ($errcode) {
                $msg = $res['errmsg'] ?? '未知错误，请联系管理员';
                throw new InvalidConfigException($msg, $errcode);
            }

            $srv = new UserService();
            $id = $srv->createData([
                'openid' => $res['openid'],
                'source' => 2,
            ]);
        } catch (InvalidConfigException $e) {
            throw new InvalidArgumentException($e->getMessage(), $e->getCode());
        }

        $token = JwtService::getToken($id);
        return [
            // 'openid' => $res['openid'],
            'access_token' => $token,
        ];
    }

}