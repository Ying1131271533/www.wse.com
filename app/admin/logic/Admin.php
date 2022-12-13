<?php
namespace app\admin\logic;

use app\common\lib\exception\Fail;
use app\common\lib\exception\Forbidden;
use app\common\lib\exception\Miss;
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
            throw new Fail('帐号不存在！');
        }

        // 用户状态
        if ($admin['status'] == 0) {
            throw new Fail('该用户被禁止登录');
        }

        // 对比密码
        $salt     = $admin['password_salt'];
        $password = md5($salt . $data['password'] . $salt);
        if ($password != $admin['password']) {
            throw new Fail('密码不正确！');
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

        // 保存token，设置过期时间：一个月
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
        // 删除token
        Token::deleteToken();
    }

    // 获取管理员列表
    public function getAdminList($data)
    {
        $where = [];
        !empty($data['idReload']) and $where[]   = ['id', '=', $data['idReload']];
        !empty($data['usernameReload']) and $where[] = ['username', 'like', "%{$data['usernameReload']}%"];
        return $this->adminModel->getAdminList($where, $data['page'], $data['limit']);
    }

    public function save($data)
    {
        // 用户是否已经存在
        $admin = AdminModel::find($data['username']);
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

    public function update($data)
    {
        // 用户是否存在
        $admin = AdminModel::find($data['id']);
        if (empty($admin)) {
            throw new Miss('该用户不存在');
        }
        // 保存管理员
        $result = $admin->save($data);
        if (!$result) {
            throw new Fail('更新失败');
        }

    }

    public function updatePassword($data)
    {
        // 用户是否存在
        $admin = AdminModel::find($data['id']);
        if (empty($admin)) {
            throw new Miss('该用户不存在');
        }

        // 生成5个字符长度的盐
        $salt = salt(5);
        // 数据加入密码盐
        $data['password_salt'] = $salt;
        // 明文密码前后加盐，生成密码
        $data['password'] = md5($salt . $data['password'] . $salt);

        // 保存
        $result = $admin->save($data);
        if (empty($result)) {
            throw new Fail('更新失败');
        }
    }

    public function changeStatus($id, $value)
    {
        $admin = AdminModel::find($id);
        if (empty($admin)) throw new Miss('管理员不存在');

        $result = $admin->save(['status' => $value]);
        if (empty($result)) throw new Fail('更新失败');
        return [
            'id' => $admin['id'],
            'value' => $admin['status'],
        ];
    }

    public function delete($id)
    {
        // 用户是否存在
        $admin = AdminModel::find($id);
        if (empty($admin)) {
            throw new Miss('该用户不存在');
        }

        // 删除token
        Token::deleteToken();

        // 删除用户，没想到不用cache(true)都能删除缓存
        $result = $admin->delete();
        if (!$result) {
            throw new Fail('删除失败！');
        }

    }
}
