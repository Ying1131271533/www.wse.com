<?php

use think\facade\Route;

Route::group('user', function(){
    // 登录
    Route::rule('index', 'User/index', 'GET');
    // 用户列表
    Route::rule('index', 'User/index', 'GET');
});