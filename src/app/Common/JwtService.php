<?php

namespace App\Common;

use App\Common\Exception\InvalidArgumentException;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JwtService
{
    /**
     * @description 加密生成token
     * @param $userId
     * @return string
     */
    public static function getToken($userId): string
    {
        $key = config('app.jwt.key');
        $payload = [
            'iat' => time(), //  token创建时间，unix时间戳格式
            // "exp" => "1548333419", //非必须。expire 指定token的生命周期。unix时间戳格式
            'user_id' => $userId,
        ];
        $token = JWT::encode($payload, $key, 'HS256');
        self::setExpireTime($token);
        return $token;
    }

    /**
     * @description 判断token 是否有效。并返回用户id
     * @throws InvalidArgumentException
     */
    public static function decode($token): array
    {
        $redis = RedisService::getInstance();
        if (!$redis->get(md5($token))) {
            throw new InvalidArgumentException('access_token is expired', 401);
        }
        $key = config('app.jwt.key');
        self::setExpireTime($token);
        $info = JWT::decode($token, new Key($key, 'HS256'));
        return json_decode(json_encode($info), true);
    }

    /**
     * @description 设置token的有效期，使用redis保存
     * 持续使用，将token的有效期延迟
     * @param $token
     * @return void
     */
    public static function setExpireTime($token)
    {
        $expireTime = config('app.jwt.expire_time');
        $redis = RedisService::getInstance();
        $redis->set(md5($token), $token, $expireTime);
    }
}