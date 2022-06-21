<?php
namespace App\Api\User;

use App\Api\Controller;
use PhalApi\Api;
use App\Domain\User\User as UserDomain;
use App\Domain\User\UserSession as UserSessionDomain;
use PhalApi\Exception\BadRequestException;

/**
 * 用户插件
 * @author dogstar 20200331
 */
class Info extends Controller {
    public function getRules() {
        return array(
            'register' => array(
                'username' => array('name' => 'username', 'require' => true, 'min' => 1, 'max' => 50, 'desc' => '账号，账号需要唯一'),
                'password' => array('name' => 'password', 'require' => true, 'min' => 6, 'max' => 20, 'desc' => '密码'),
                'avatar' => array('name' => 'avatar', 'default' => '', 'max' => 500, 'desc' => '头像链接'),
                'sex' => array('name' => 'sex', 'type' => 'int', 'default' => 0, 'desc' => '性别，1男2女0未知'),
                'email' => array('name' => 'email', 'default' => '', 'max' => 50, 'desc' => '邮箱'),
                'mobile' => array('name' => 'mobile', 'default' => '', 'max' => 20, 'desc' => '手机号'),
            ),
            'login' => array(
                'username' => array('name' => 'username', 'require' => true, 'min' => 1, 'max' => 50, 'desc' => '账号'),
                'password' => array('name' => 'password', 'require' => true, 'min' => 6, 'max' => 20, 'desc' => '密码'),
            ),
            'checkSession' => array(
                'user_id' => array('name' => 'user_id', 'type' => 'int', 'require' => true, 'desc' => '用户ID'),
                'token' => array('name' => 'token', 'require' => true, 'desc' => '会话token'),
            ),
            'profile' => array(
                'user_id' => array('name' => 'user_id', 'type' => 'int', 'require' => true, 'desc' => '用户ID'),
                'token' => array('name' => 'token', 'require' => true, 'desc' => '会话token'),
            ),
        );
    }

    public function code()
    {
        return [
            'code' => "success",
            'user_id' => $this->userId,
        ];
    }

} 
