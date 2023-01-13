<?php

namespace app\common\model;

class Admin extends BaseModel
{
    // 关联角色
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    // 查询用户，根据用户名和密码
    public static function findAdminByUserNameWithPassword($username, $password)
    {
        return self::where(['username' => $username, 'password' => $password])->find();
    }

    public static function findAdminById(int $id)
    {
        return self::with('roles')
        ->withoutField([
            'password',
            'password_salt',
            'last_login_token',
            'login_number',
            'last_login_ip',
            'last_login_time',
            'create_time'
        ])
        ->find($id);
    }

    public static function findAdminByUserName($username)
    {
        return self::where('username', $username)->find();
    }

    public static function findByUserNameWithStatus($username)
    {
        return self::where('username', $username)->where('status', 1)->find();
    }

    public static function findByIdWithStatus($id)
    {
        return self::where('id', $id)->where('status', 1)->find();
    }

    public static function getAdminList($where, $page, $limit)
    {
        return self::withoutField(['password', 'password_salt', 'last_login_token'])
        ->where($where)
        ->order('id', 'asc')
        ->paginate($limit, false, ['page' => $page])
        ->toArray();
    }
}
