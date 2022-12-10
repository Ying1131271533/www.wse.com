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
    // 退出登录
    Route::rule('logout', 'Admin/logout', 'POST');
    // 列表
    Route::rule('index', 'Admin/index', 'GET');
    // 单条
    Route::rule('read/:id', 'Admin/read', 'GET');
    // 保存
    Route::rule('save', 'Admin/save', 'POST');
    // 更新
    Route::rule('update', 'Admin/update', 'PUT');
    // 删除
    Route::rule('delete/:id', 'Admin/delete', 'DELETE');
    // 更新密码
    Route::rule('password', 'Admin/password', 'PUT');
    // 获取用户token
    Route::rule('get_admin_by_token', 'Admin/getAdminByToken', 'POST');
})->middleware(app\admin\middleware\IsLogin::class);