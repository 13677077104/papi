<?php

namespace App\Dao;

/**
 * @property int $id
 * @property string $openid
 * @property string|null $username
 * @property string|null $nickname
 * @property string $password
 * @property string $salt
 * @property int $reg_time
 * @property string|null $avatar
 * @property string|null $mobile
 * @property int|null $sex
 * @property string|null $email
 * @property int $status
 * @property int $created_time
 * @property int $updated_time
 */

class UserDao
{
    /**
     * @param string $openid
     */
    public function setOpenid(string $openid): void
    {
        $this->openid = $openid;
    }

    /**
     * @param string|null $username
     */
    public function setUsername(?string $username): void
    {
        $this->username = $username;
    }

    /**
     * @param string|null $nickname
     */
    public function setNickname(?string $nickname): void
    {
        $this->nickname = $nickname;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @param string $salt
     */
    public function setSalt(string $salt): void
    {
        $this->salt = $salt;
    }

    /**
     * @param int $reg_time
     */
    public function setRegTime(int $reg_time): void
    {
        $this->reg_time = $reg_time;
    }

    /**
     * @param string|null $avatar
     */
    public function setAvatar(?string $avatar): void
    {
        $this->avatar = $avatar;
    }

    /**
     * @param string|null $mobile
     */
    public function setMobile(?string $mobile): void
    {
        $this->mobile = $mobile;
    }

    /**
     * @param int|null $sex
     */
    public function setSex(?int $sex): void
    {
        $this->sex = $sex ?? 0;
    }

    /**
     * @param string|null $email
     */
    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    /**
     * @param int $status
     */
    public function setStatus(int $status): void
    {
        $this->status = $status;
    }

    /**
     * @param int $created_time
     */
    public function setCreatedTime(int $created_time): void
    {
        $this->created_time = $created_time;
    }

    /**
     * @param int $updated_time
     */
    public function setUpdatedTime(int $updated_time): void
    {
        $this->updated_time = $updated_time;
    }
}