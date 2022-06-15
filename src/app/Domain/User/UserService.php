<?php

namespace App\Domain\User;

use App\Model\User\UserModel;
use PhalApi\Tool;

class UserService
{
    public function getByOpenid($openid)
    {
        $model = new UserModel();
        return $model->getByOpenid($openid);
    }

    public function createData($data)
    {
        $data['status'] = 1;
        $password = $data['password'] ?? 'test@123';
        $data['salt'] = Tool::createRandStr(32);
        $data['password'] = encryptPassword($password, $data['salt']);
        $data['reg_time'] = $_SERVER['REQUEST_TIME'];

        $model = new UserModel();
        $exist = $model->getByOpenid($data['openid']);
        if ($exist) {
            $model->updateById($exist['id'], $data);
            $id = $exist['id'];
        }else{
            $id = $model->create($data);
        }
        return $id;
    }
}