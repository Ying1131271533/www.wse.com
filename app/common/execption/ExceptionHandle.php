<?php
namespace app\common\execption;

use app\common\lib\exception\BaseException;
use app\Request;
use think\db\exception\DataNotFoundException;
use think\db\exception\ModelNotFoundException;
use think\exception\Handle;
use think\exception\HttpException;
use think\exception\HttpResponseException;
use think\exception\ValidateException;
use think\Response;
use Throwable;

/**
 * 应用异常处理类
 */
class ExceptionHandle extends Handle
{
    /**
     * 不需要记录信息（日志）的异常类列表
     * @var array
     */
    protected $ignoreReport = [
        HttpException::class,
        HttpResponseException::class,
        ModelNotFoundException::class,
        DataNotFoundException::class,
        ValidateException::class,
    ];

    /**
     * 记录异常信息（包括日志或者其它方式记录）
     *
     * @access public
     * @param  Throwable $exception
     * @return void
     */
    public function report(Throwable $exception): void
    {
        // 使用内置的方式记录异常日志
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @access public
     * @param \think\Request   $request
     * @param Throwable $e
     * @return Response
     */
    public function render($request, Throwable $e): Response
    {
        // 添加自定义异常处理机制
        if ($e instanceof BaseException) {
            return show($e->msg, $e->errorCode, $e->httpStatus, $e->data);
        }
        
        $message = $e->getMessage();
        // $message = mb_convert_encoding($message, 'UTF-8', 'UTF-8,GBK,GB2312,BIG5');

        if ($e instanceof \Exception) {
            if (env('APP_DEBUG')) {
                // 这里打开后，就只显示错误信息，而没有详细的页面错误提示了
                return show($message, $e->getCode());
            } else {
                return show('系统内部错误', $e->getCode());
            }
        }

        // 其他错误交给系统处理
        return parent::render($request, $e);
    }
}
