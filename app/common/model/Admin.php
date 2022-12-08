<?php

namespace app\common\model;

class Admin extends BaseModel
{
    // 查询用户，根据用户名和密码
    public function findAdminByUserNameWithPassword($username, $password)
    {
        return $this->where(['username' => $username, 'password' => $password])->find();
    }

    public static function findAdminById(int $id)
    {
        return self::cache(cache_time())
        ->withoutField(['password', 'password_salt', 'last_login_token', 'login_number', 'last_login_ip', 'last_login_time', 'create_time'])
        ->find($id);
    }

    public function findAdminByUserName($username)
    {
        return $this->where('username', $username)->find();
    }

    public function findByUserNameWithStatus($username)
    {
        return $this->where('username', $username)->where('status', 1)->find();
    }

    public function adminList($page, $limit)
    {
        return $this->withoutField(['password', 'password_salt', 'last_login_token'])
        ->order('id', 'asc')
        ->paginate($limit, false, ['page' => $page])
        ->toArray();
    }
}