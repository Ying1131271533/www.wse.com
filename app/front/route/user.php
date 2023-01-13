<?php

use think\facade\Route;

// 管理员
Route::group('', function(){
    // 登录
    Route::rule('login', 'User/userLogin', 'GET');
    // 注册
    Route::rule('register', 'User/userRegister', 'GET');
});
