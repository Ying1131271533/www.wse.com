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
    Route::rule('admin_update/:id', 'View/adminUpdate', 'GET');
    // 更改密码
    Route::rule('admin_password/:id', 'View/adminPassword', 'GET');
});

// 角色
Route::group('view', function(){
    Route::rule('role_index', 'View/roleIndex', 'GET');
    Route::rule('role_save', 'View/roleSave', 'GET');
    Route::rule('role_update/:id', 'View/roleUpdate', 'GET');
    Route::rule('role_auth/:id', 'View/roleAuth', 'GET');
});

// 节点
Route::group('view', function(){
    Route::rule('node_index', 'View/nodeIndex', 'GET');
    Route::rule('node_save', 'View/nodeSave', 'GET');
    Route::rule('node_update/:id', 'View/nodeUpdate', 'GET');
});





















































































