<?php

use think\facade\Route;

Route::group('user', function(){
    // 用户主页
    Route::rule('index', 'User/index', 'GET');
    // 注册
    Route::rule('register', 'User/register', 'GET');
    // 登录
    Route::rule('login', 'User/login', 'GET');
});