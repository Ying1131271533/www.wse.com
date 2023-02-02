<?php


use think\facade\Route;

// 管理员
Route::group('', function(){
    // 登录
    Route::rule('login', 'Admin/login', 'POST');
});


Route::group('admin', function(){
    // 验证登录
    Route::rule('is_login', 'Admin/isLogin', 'POST');
    // 退出登录
    Route::rule('logout', 'Admin/logout', 'POST');
    // 获取用户
    Route::rule('get_admin_by_token', 'Admin/getAdminByToken', 'POST');
    // 获取用户拥有的显示节点
    Route::rule('get_show_node', 'Admin/getShowNode', 'GET');
})->middleware(app\admin\middleware\IsLogin::class);

// 管理员
Route::group('admin', function(){
    // 列表
    Route::rule('', 'Admin/index', 'GET');
    // 单条
    Route::rule(':id', 'Admin/read', 'GET');
    // 保存
    Route::rule('', 'Admin/save', 'POST');
    // 更新
    Route::rule('', 'Admin/update', 'PUT');
    // 删除
    Route::rule(':id', 'Admin/delete', 'DELETE');
    // 更新密码
    Route::rule('password', 'Admin/password', 'PUT');
})->middleware([app\admin\middleware\IsLogin::class, app\admin\middleware\CheckAuth::class]);