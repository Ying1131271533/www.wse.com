<?php

use think\facade\Route;

// 主页
Route::group('view', function(){
    // 主页框架界面
    Route::rule('index', 'View/index', 'GET');
    // 欢迎
    Route::rule('welcome', 'View/welcome', 'GET');
});

// 管理员
Route::group('view', function(){
    // 登录
    Route::rule('login', 'View/login', 'GET');
    // 列表
    Route::rule('admin_index', 'View/adminIndex', 'GET');
    // 保存
    Route::rule('admin_save', 'View/adminSave', 'GET');
    // 更新
    Route::rule('admin_update', 'View/adminUpdate', 'GET');
});