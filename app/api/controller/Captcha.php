<?php
namespace app\api\controller;

use think\captcha\facade\Captcha as FacadeCaptcha;

class Captcha 
{
	public function createVerify()
    {
        return FacadeCaptcha::create('register');
        $captcha = FacadeCaptcha::create('register');
        return success([
            'captcha' => $captcha,
            'session_id' => create_session_id()
        ]);
    }
}
