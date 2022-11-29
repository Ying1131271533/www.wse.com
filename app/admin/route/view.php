<?php

use think\facade\Route;

Route::group('view', function(){
    // 主页框架界面
    Route::rule('index', 'View/index', 'GET');
    // 欢迎
    Route::rule('welcome', 'View/welcome', 'GET');
});

Route::group('view', function(){
    // 管理员登录
    Route::rule('login', 'View/login', 'GET');
    // 管理员列表
    Route::rule('admin_index', 'View/index', 'GET');
});