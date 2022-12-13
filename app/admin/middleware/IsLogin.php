<?php

namespace app\admin\middleware;

use app\BaseController;
use app\common\lib\exception\Fail;
use app\common\lib\exception\Forbidden;
use app\common\lib\exception\Jump;
use app\common\lib\exception\Miss;
use app\common\lib\Token;
use app\common\model\Admin as AdminModel;

class IsLogin extends BaseController
{
    public function handle($request, \Closure $next)
    {
        // 获取token
        $token = Token::getToken();
        if (empty($token)) {
            throw new Jump('非法请求~无效的token');
        }

        // 使用token获取用户信息
        $user = Token::getUser($token);
        if (empty($user)) {
            throw new Jump('登录过期，请重新登录！~');
        }

        // 找到用户
        $user = AdminModel::cache(cache_time())->find($user['id']);
        if(empty($user)){
            Token::deleteToken();
            throw new Forbidden('该用户已被删除');
        }else if($user['status'] == 0){
            Token::deleteToken();
            throw new Forbidden('该用户被禁止登录');
        }

        // 账号异地登录
        // 异地登录会生成新的token，同时删除旧的token缓存
        // 那么当前还没重新登录的token就会直接过期，需要重新登录
        // $user = (new Admin())->findByUserNameWithStatus($user['username']);
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