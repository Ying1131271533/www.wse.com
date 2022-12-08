<?php
namespace app\admin\logic;

use app\common\lib\Token;
use app\common\logic\lib\Redis;
use app\common\logic\lib\Str;
use app\common\model\Admin as AdminModel;
use Exception;

class Admin
{
    private $adminModel = null;
    private $str        = null;
    private $redis      = null;

    public function __construct()
    {
        $this->adminModel = new AdminModel();
        $this->str        = new Str();
        $this->redis      = new Redis();
    }

    // 登录
    public function login($data)
    {
        // 找到管理员
        $admin = $this->adminModel->findAdminByUserName($data['username']);
        if (empty($admin)) {
            throw new Exception('帐号不存在！');
        }

        // 对比密码
        $salt     = $admin['password_salt'];
        $password = md5($salt . $data['password'] . $salt);
        if ($password != $admin['password']) {
            throw new Exception('密码不正确！');
        }

        // 如果IsLogin中间件那里使用了账号异地登录的话，就删除redis的token
        // 删除上次的token
        // $this->redis->delete(config('redis.token_pre') . $admin['last_login_token']);

        // 生成token
        $token = $this->str->createToken($admin['username']);

        // 更新用户登录信息
        $admin->save([
            'last_login_token' => $token,
            'login_number'     => $admin['login_number'] + 1,
            'last_login_ip'    => get_client_ip(),
            'last_login_time'  => time(),
        ]);

        // 保存token，设置过期时间 - 一个月
        $this->redis->set(config('redis.token_pre') . $token, [
            'id'       => $admin['id'],
            'username' => $admin['username'],
        ], cache_time('one_month'));

        // 返回token
        return $token;
    }

    // 退出登录
    public function logout()
    {
        // 获取token
        $token = Token::getToken();
        // 删除token
        $this->redis->delete(config('redis.token_pre') . $token);
    }

    // 管理员列表
    public function adminList($page, $limit)
    {
        return $this->adminModel->adminList($page, $limit);
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
