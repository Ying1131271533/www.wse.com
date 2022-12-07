<?php


use think\facade\Route;

// 管理员
Route::group('admin', function(){
    // 登录
    Route::rule('login', 'Admin/login', 'POST');
});

// 管理员
Route::group('admin', function(){
    // 验证登录
    Route::rule('is_login', 'Admin/isLogin', 'POST');
    // 管理员列表
    Route::rule('index', 'Admin/index', 'GET');
    // 管理员保存
    Route::rule('save', 'Admin/save', 'POST');
    // 管理员更新
    Route::rule('upate', 'Admin/upate', 'PUT');
})->middleware(app\admin\middleware\IsLogin::class);