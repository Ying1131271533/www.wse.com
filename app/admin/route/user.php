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
})->middleware([app\admin\middleware\IsLogin::class, app\admin\middleware\CheckAuth::class]);