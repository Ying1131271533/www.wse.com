<?php

namespace app\api\middleware;

use app\common\lib\exception\Forbidden;
use app\common\lib\exception\Jump;
use app\common\lib\facade\ApiToken;
use app\common\model\User as UserModel;

class IsLogin
{
    public function handle($request, \Closure $next)
    {
        // 获取token
        $token = ApiToken::getToken();
        if (empty($token)) {
            throw new Jump('非法请求~无效的token');
        }

        // 使用token获取用户信息
        $user = ApiToken::getUser($token);
        if (empty($user)) {
            throw new Jump('登录过期，请重新登录！~');
        }

        // 找到用户
        $user = UserModel::cache('user:' . $user['id'], cache_time())->find($user['id']);
        if (empty($user)) {
            ApiToken::deleteToken();
            throw new Forbidden('该用户已被删除');
        } else if ($user['status'] == 0) {
            ApiToken::deleteToken();
            throw new Forbidden('该用户被禁止登录');
        }

        // 账号异地登录
        // 异地登录会生成新的token，同时删除旧的token缓存
        // 那么当前上次登录的token就会直接过期，需要重新登录
        // $user = (new User())->findByUserNameWithStatus($user['username']);
        // if($user['last_login_token'] != $token){
        //     return $this->show(
        //         config('status.goto'),
        //         config('message.goto'),
        //         ' 账号异地登录，请重新登录！'
        //     );
        // }

        return $next($request);
    }
}
