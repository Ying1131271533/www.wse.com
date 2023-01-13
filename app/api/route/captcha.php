<?php

use think\facade\Route;

Route::group('captcha', function(){
    // 上传文件
    Route::rule('create_verify', 'Captcha/createVerify', 'GET');
});