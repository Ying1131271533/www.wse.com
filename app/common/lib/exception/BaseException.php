<?php
namespace app\common\lib\exception;

use think\Exception;

abstract class BaseException extends Exception
{
    public $msg    = '成功';
    public $HttpStatus   = 200;
    public $code = 200;
    public $data   = [];

    public function __construct($params = [])
    {
        if(is_string($params) && (int)($params) == 0){
            $this->msg = $params;
            return;
        }

        if (!is_array($params) || empty($params)) {
            return;
        }

        if (array_key_exists('msg', $params)) {
            $this->msg = $params['msg'];
        }

        if (array_key_exists('HttpStatus', $params)) {
            $this->HttpStatus = $params['HttpStatus'];
        }

        if (array_key_exists('code', $params)) {
            $this->code = $params['code'];
        }

        if (array_key_exists('data', $params)) {
            $this->data = $params['data'];
        }
    }
}
