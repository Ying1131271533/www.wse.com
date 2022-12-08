<?php
namespace app\common\lib\exception;

class Fail extends BaseException
{
    public $msg    = '失败';
    public $errorCode   = 100;
    public $httpStatus = 200;
}
