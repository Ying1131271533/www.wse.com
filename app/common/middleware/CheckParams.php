<?php
namespace app\common\middleware;

use app\common\lib\exception\Params;
use think\exception\ValidateException;

/**
 * 验证参数，参数过滤
 *
 * @param Request       $request 请求对象
 * @param Closure       $next
 * @return return       $next($request);
 */
class CheckParams
{
    public function handle($request, \Closure $next)
    {
        // 验证请求是否超时
        // $this->check_time($params['time']);
        // 验证参数，参数过滤

        // if ($request->action() == 'index') { }

        $this->check_param($request);
        return $next($request);
    }

    /**
     * 验证参数，参数过滤
     *
     * @param array     $array   [除time和token外的所有参数]
     * @return return            [合格的参数数组]
     */
    public function check_param($request)
    {
        $root       = $request->root(); // 应用目录
        $root       = str_replace('/', '\\', $root); // 替换斜杠
        $controller = $request->controller(); // 控制器
        $action     = $request->action(); // 方法名
        $params     = $request->filter(['htmlspecialchars'])->all(); // 获取当前参数

        // halt($params);

        // 拼接验证类名，注意路径不要出错
        // $validateClassName = 'app' . $root . '\validate\\' . $controller;
        $validateClassName = 'app\\common\\validate\\' . $controller;

        // 判断当前验证类是否存在
        if (class_exists($validateClassName)) {
            $validate = new $validateClassName;
            // 仅当存在验证场景才校验
            if ($validate->hasScene($action)) {

                // 设置当前验证场景
                $validate->scene($action);
                // 校验不通过则直接返回错误信息
                if (!$validate->check($params)) {
                    // 红叶的命名方式就用下面这个
                    throw new \Exception($validate->getError(), config('status.failed'));
                }
                // 返回检测通过的参数
                $resultParams    = $validate->getDateByRule($params);
                $request->params = $resultParams;
                // 分页参数
                $request->page = $request->param('?page') ? $request->param('page') : config('app.page');
                $request->size = $request->param('?limit') ? $request->param('limit') : config('app.limit');
            }
        } /* else{
    $request->params = $params;
    } */
    }
}
