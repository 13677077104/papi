<?php

namespace App\Model\User;

use App\Common\ModelInterface;
use App\Dao\UserDao;
use PhalApi\Model\DataModel;
use PhalApi\Tool;

class UserModel extends DataModel implements ModelInterface
{
    public function create($data)
    {
        $tmpName = "tmp_name_" . Tool::createRandStr(10);
        $dao = new UserDao();
        $dao->setOpenid($data['openid']);
        $dao->setUsername($data['username'] ?? $tmpName);
        $dao->setNickname($data['nickname']);
        $dao->setPassword($data['password']);
        $dao->setSalt($data['salt']);
        $dao->setRegTime($data['reg_time']);
        $dao->setAvatar($data['avatar']);
        $dao->setMobile($data['mobile']);
        $dao->setSex($data['sex']);
        $dao->setEmail($data['email']);
        $dao->setStatus($data['status']);
        $dao->setCreatedTime(time());
        $dao->setUpdatedTime(time());

        return $this->insert((array)$dao);
    }

    public function query($where): array
    {
        // TODO: Implement query() method.
    }

    public function queryByPage($where, int $page, int $pageSize): array
    {
        // TODO: Implement queryByPage() method.
    }

    public function updateById($id, $data): bool
    {
        $dao = new UserDao();
        if ($data['username']) {
            $dao->setUsername($data['username']);
        }
        if ($data['nickname']) {
            $dao->setNickname($data['nickname']);
        }
        if ($data['password']) {
            $dao->setPassword($data['password']);
        }
        if ($data['salt']) {
            $dao->setSalt($data['salt']);
        }
        if ($data['reg_time']) {
            $dao->setRegTime($data['reg_time']);
        }
        if ($data['avatar']) {
            $dao->setAvatar($data['avatar']);
        }
        if ($data['mobile']) {
            $dao->setMobile($data['mobile']);
        }
        if ($data['sex']) {
            $dao->setSex($data['sex']);
        }
        if ($data['email']) {
            $dao->setEmail($data['email']);
        }
        if ($data['status']) {
            $dao->setStatus($data['status']);
        }
        $dao->setUpdatedTime(time());
        return $this->update($id, (array)$dao);
    }

    public function deleteById($id): bool
    {
        return $this->update($id, ['status' => 20]);
    }

    public function getByOpenid($openid)
    {
        return $this->getORM()->where(['openid' => $openid])->fetchOne();
    }

    protected function getTableName($id): string
    {
        return 'phalapi_user';
    }
}