<?php
namespace app\common\lib\exception;

class Unauthorized extends BaseException
{
    public $msg    = '未经授权';
    public $HttpStatus   = 401;
    public $code = 40001;
}
