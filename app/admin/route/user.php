<?php

use think\facade\Route;

Route::group('user', function(){
    // 列表
    Route::rule('', 'User/index', 'GET');
    // 读取
    Route::rule(':id', 'User/read', 'GET');
    // 更新
    Route::rule('', 'User/update', 'PUT');
    // 删除
    Route::rule(':id', 'User/delete', 'DELETE');
    // 更新密码
    Route::rule('password', 'User/password', 'PUT');

    
    // 用户信息 这种路由命名挺有意思
    Route::rule(':id/info', 'User/info', 'GET');
    // 用户资金明细
    Route::rule(':id/mingxi', 'User/mingxi', 'GET');
})->middleware([app\admin\middleware\IsLogin::class, app\admin\middleware\CheckAuth::class]);