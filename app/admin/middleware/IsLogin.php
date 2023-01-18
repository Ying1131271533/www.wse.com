<?php

namespace app\admin\middleware;

use app\BaseController;
use app\common\lib\exception\Fail;
use app\common\lib\exception\Forbidden;
use app\common\lib\exception\Jump;
use app\common\lib\exception\Miss;
use app\common\lib\facade\Token;
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

        // 使用token获取管理员信息
        $admin = Token::getUser($token);
        if (empty($admin)) {
            throw new Jump('登录过期，请重新登录！~');
        }

        // 找到管理员
        $admin = AdminModel::cache('admin:' . $admin['id'], cache_time())->find($admin['id']);
        // 下次要升级缓存方式
        // $admin = AdminModel::cache('admin:' . $admin['id'] . config('redis.info'), cache_time())->find($admin['id']);
        if (empty($admin)) {
            Token::deleteToken();
            throw new Forbidden('该管理员已被删除');
        } else if ($admin['status'] == 0) {
            Token::deleteToken();
            throw new Forbidden('该管理员被禁止登录');
        }

        // 账号异地登录
        // 异地登录会生成新的token，同时删除旧的token缓存
        // 那么当前还没重新登录的token就会直接过期，需要重新登录
        // $admin = (new Admin())->findByUserNameWithStatus($admin['username']);
        // if($admin['last_login_token'] != $token){
        //     return $this->show(
        //         config('status.goto'),
        //         config('message.goto'),
        //         ' 账号异地登录，请重新登录！'
        //     );
        // }

        return $next($request);
    }
}
