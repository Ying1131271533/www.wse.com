<?php
namespace app\common\lib\exception;

class Fail extends BaseException
{
    public $msg    = '失败';
    public $HttpStatus   = 400;
    public $code = 400;
}
