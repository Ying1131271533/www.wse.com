<?php

namespace app\common\model;

class Admin extends BaseModel
{
    // 查询用户，根据用户名和密码
    public function findAdminByUserNameWithPassword($username, $password)
    {
        return $this->where(['username' => $username, 'password' => $password])->find();
    }

    public function findAdminByUserName($username)
    {
        return $this->where('username', $username)->find();
    }

    public function adminList($page, $size)
    {
        return $this->withoutField(['password', 'password_salt'])
        ->limit($size)
        ->page($page)
        ->order('id', 'asc')
        ->select();
    }
}
