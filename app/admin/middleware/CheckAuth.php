<?php

namespace app\admin\middleware;

use app\admin\logic\Auth;
use app\common\lib\exception\Forbidden;

class CheckAuth
{
    public function handle($request, \Closure $next)
    {
        $auth = new Auth();
        $result = $auth->check();
        if($result === false){
            throw new Forbidden();
        }
        
        if($result === 2) {
            throw new Forbidden('您已被停用权限');
        }

        return $next($request);
    }
}