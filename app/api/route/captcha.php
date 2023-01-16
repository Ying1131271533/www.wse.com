<?php

use think\facade\Route;

Route::group('captcha', function(){
    // 创建验证码
    Route::rule('create_verify', 'Captcha/createVerify', 'GET');
});

// 注册验证码的路由
// Route::get('captcha/:id','\\think\\captcha\\CaptchaController@index')->allowCrossDomain();