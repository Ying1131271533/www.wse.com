<?php
namespace app\admin\logic;

use app\common\logic\lib\Str;
use app\common\model\Admin as AdminModel;
use Exception;

class Admin
{
    private $adminModel = null;
    private $str        = null;

    public function __construct()
    {
        $this->adminModel = new AdminModel();
        $this->str        = new Str();
    }

    // 管理员列表
    public function adminList($data)
    {
        return $this->adminModel->adminList($data['page'], $data['size']);
    }

    public function save($data)
    {
        // 用户是否已经存在
        $admin = $this->adminModel->findAdminByUserName($data['username']);
        if (!empty($admin)) {
            throw new Exception('用户名已被注册！');
        }

        // 生成5个字符长度的盐
        $salt = $this->str->salt(5);
        // 数据加入密码盐
        $data['password_salt'] = $salt;
        // 明文密码前后加盐，生成密码
        $data['password'] = md5($salt . $data['password'] . $salt);

        // 保存管理员
        $this->adminModel->save($data);
    }
}
