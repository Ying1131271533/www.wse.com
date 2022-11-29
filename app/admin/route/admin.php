<?php

use think\facade\Route;

// 管理员
Route::group('admin', function(){
    // 登录
    Route::rule('login', 'Admin/login', 'POST');
    // 管理员列表
    Route::rule('index', 'Admin/index', 'GET');
});