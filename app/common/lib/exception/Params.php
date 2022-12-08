<?php
namespace app\common\lib\exception;

class Params extends BaseException
{
    public $msg    = '参数错误';
    public $errorCode   = 100;
    public $httpStatus = 200;
}
