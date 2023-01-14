<?php
namespace app\api\logic;

use app\common\lib\exception\Fail;
use app\common\lib\ApiToken;
use app\common\lib\exception\Miss;
use app\common\lib\Hashids;
use app\common\logic\lib\Redis;
use app\common\logic\lib\Str;
use app\common\model\User as UserModel;
use Exception;

class User
{
    public static function register($data)
    {
        // 用户是否已经存在
        $user = UserModel::find($data['username']);
        if (!empty($user)) throw new Fail('用户名已被注册！');

        // 生成5个字符长度的盐
        $salt = Str::salt(5);
        // 数据加入密码盐
        $data['password_salt'] = $salt;
        // 明文密码前后加盐，生成密码
        $data['password'] = md5($salt . $data['password'] . $salt);

        // 如果邀请码不为空
        if(!empty($data['invitation_code'])){

            // 实例化Hashids，邀请码长度为6
            $hashids = Hashids::instance(config('app.invitation_code_length'));
            // 反向解密，获取用户
            $invitation_user_id = $hashids->decode($data['invitation_code']);
            if(empty($invitation_user_id)) throw new Fail('邀请码无效');

            // 邀请用户是否存在
            $invitation_user = UserModel::find($invitation_user_id);
            if(empty($invitation_user)) throw new Miss('邀请用户不存在');

            // 用户数据加入邀请用户id
            $data['invitation_user_id'] = $invitation_user_id;
        }

        // 启动事务
        $user->startTrans();

        try {
            // 保存用户
            $userResult = $user->save($data);
            if (!$userResult) throw new Exception('用户注册失败');

            // 提交事务
            $user->commit();
            return $user;
        } catch (Exception $e) {
            $user->rollback();
            throw new Fail($e->getMessage());
        }
    }

    // 登录
    public static function login($data)
    {
        // 找到用户
        $user = UserModel::findUserByUserName($data['username']);
        if (empty($user)) {
            throw new Fail('帐号不存在！');
        }

        // 用户状态
        if ($user['status'] == 0) {
            throw new Fail('该用户被禁止登录');
        }

        // 对比密码
        $salt     = $user['password_salt'];
        $password = md5($salt . $data['password'] . $salt);
        if ($password != $user['password']) {
            throw new Fail('密码不正确！');
        }

        $redis = new Redis();
        // 如果IsLogin中间件那里使用了账号异地登录的话，就删除redis的token
        // 删除上次的token
        // $redis->delete(config('redis.token_pre') . $user['last_login_token']);

        // 生成token
        $token = Str::createToken($user['username']);

        // 更新用户登录信息
        $user->save([
            'last_login_token' => $token,
            'login_number'     => $user['login_number'] + 1,
            'last_login_ip'    => get_client_ip(),
            'last_login_time'  => time(),
        ]);

        $data = [
            'id'       => $user['id'],
            'username' => $user['username'],
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
        ApiToken::deleteToken();
    }

    // 生成邀请码
    public static function createInvitationCode()
    {
        // 实例化Hashids，邀请码长度为6
        $hashids = Hashids::instance(config('app.invitation_code_length'));
        // 获取用户id
        $user_id = ApiToken::getUid();
        // 根据用户Id加密
        $invitation_code = $hashids->encode($user_id);
        // 返回数据
        return $invitation_code;
    }
}
