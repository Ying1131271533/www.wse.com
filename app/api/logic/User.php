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
    public static function register($data)
    {
        // 用户是否已经存在
        $admin = AdminModel::find($data['username']);
        if (!empty($admin)) {
            throw new Exception('用户名已被注册！');
        }

        // 生成5个字符长度的盐
        $salt = Str::salt(5);
        // 数据加入密码盐
        $data['password_salt'] = $salt;
        // 明文密码前后加盐，生成密码
        $data['password'] = md5($salt . $data['password'] . $salt);

        // 启动事务
        $admin->startTrans();

        try {
            // 保存用户
            $adminResult = $admin->save($data);
            if (!$adminResult) {
                throw new Exception('用户注册失败');
            }

            // 提交事务
            $admin->commit();
            return $admin;
        } catch (Exception $e) {
            $admin->rollback();
            throw new Fail($e->getMessage());
        }
    }

    // 登录
    public static function login($data)
    {
        // 找到用户
        $admin = AdminModel::findAdminByUserName($data['username']);
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

        $redis = new Redis();
        // 如果IsLogin中间件那里使用了账号异地登录的话，就删除redis的token
        // 删除上次的token
        // $redis->delete(config('redis.token_pre') . $admin['last_login_token']);

        // 生成token
        $token = Str::createToken($admin['username']);

        // 更新用户登录信息
        $admin->save([
            'last_login_token' => $token,
            'login_number'     => $admin['login_number'] + 1,
            'last_login_ip'    => get_client_ip(),
            'last_login_time'  => time(),
        ]);

        $data = [
            'id'       => $admin['id'],
            'username' => $admin['username'],
        ];
        
        // 保存token，设置过期时间：一个月
        $redis->set(config('redis.token_pre') . $token, $data, cache_time('one_month'));

        // 返回token
        return $token;
    }

    // 退出登录
    public static function logout()
    {
        // 删除token
        Token::deleteToken();
    }
}
