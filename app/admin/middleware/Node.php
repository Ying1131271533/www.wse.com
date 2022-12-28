<?php

namespace app\admin\middleware;


/**
 * 节点中间件
 *
 * @param Request     $request      请求对象
 * @param Closure     $next         中间件对象
 * @return return                   $next($request);
 */
class Node
{
    public function handle($request, \Closure $next)
    {
        // 检验保存和更新的方法传递的参数
        if ($request->action() == 'save' || $request->action() == 'update') {
            // icon不转义字符
            $request->icon = $request->param('icon', '', 'strip_tags');
        }
        
        return $next($request);
    }

}
