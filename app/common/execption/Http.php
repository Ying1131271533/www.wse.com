<?php

namespace app\common\execption;

use think\exception\Handle; // 异常处理接管
use think\Response;

class Http extends Handle
{
    private $msg    = null;
    private $status = null;

    // 异常处理接管
    public function render($request, \Throwable $e): Response
    {
        $this->msg    = $e->getMessage();
        $this->status = config('status.failed');
        if ($this->status == config('status.goto')) {
            $this->status = config('sataus.goto');
        }
        // 编码UTF-8
        // $array = $this->changeToUtf8([
        //     'status'  => $this->status,
        //     'message' => $this->msg,
        //     'result'  => null,
        // ]);
        $array = [
            'status'  => $this->status,
            'message' => $this->msg,
            'result'  => null
        ];
        return json($array);
    }

    /**
     * 将获取的服务器信息中的中文编码转为utf-8
     * 修复在开启debug模式时出现的Malformed UTF-8 characters 错误
     * @access protected
     * @param $data array
     * @return array                 转化后的数组
     */
    protected function changeToUtf8(array $data): array
    {
        foreach ($data as $key => $value) {
            $data[$key] = mb_convert_encoding($value, "UTF-8", "GBK, GBK2312");
        }

        return $data;
    }
}
