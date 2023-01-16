<?php
namespace app\api\controller;

use imyfone\TheCaptcha;
use think\captcha\facade\Captcha as FacadeCaptcha;

class Captcha
{
    public function createVerify()
    {
        $captcha = new TheCaptcha(config('captcha.register'));
        $obj  = $captcha->getEntry();
        $data = $obj->getData(); // 得到的结果是数组
        return success($data);
    }
}
