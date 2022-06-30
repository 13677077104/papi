<?php

namespace App\Api;

use App\Common\Exception\InvalidArgumentException;
use App\Common\JwtService;
use Exception;
use PhalApi\Api;

/**
 * 接口基类
 */
class Controller extends Api
{
    protected $userId;

    /**
     * @description 校验access_token 设置全局user_id
     * @throws InvalidArgumentException
     */
    public function userCheck()
    {
        $auth = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
        $token = explode(' ', $auth)[1];

        if (!$this->inWhitelistIp()) {
            if (!$token) {
                throw new InvalidArgumentException("access_token can not blank", 1000);
            }
            try {
                $info = JwtService::decode($token);
            } catch (Exception $e) {
                throw new InvalidArgumentException($e->getMessage(), $e->getCode());
            }

            $this->userId = $info['user_id'];
        }

    }

    public function inWhitelistIp(): bool
    {
        $ip = getClientIp();
        $whitelistIp = [
            'localhost',
            'mp.zane.com',
        ];
        if (in_array($ip, $whitelistIp)) {
            return true;
        }
        return false;
    }


}
