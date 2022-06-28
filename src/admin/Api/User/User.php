<?php

namespace Admin\Api\User;

use PhalApi\Api;

class User extends Api
{
    /**
     * @desc 获取信息
     */
    public function getInfo()
    {
        return array('xAxisData' => 'success');
    }
}