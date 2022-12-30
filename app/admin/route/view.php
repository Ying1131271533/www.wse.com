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
    // 更改密码
    Route::rule('admin_password', 'View/adminPassword', 'GET');
});

// 角色
Route::group('view', function(){
    Route::rule('role_index', 'View/roleIndex', 'GET');
    Route::rule('role_save', 'View/roleSave', 'GET');
    Route::rule('role_update', 'View/roleUpdate', 'GET');
    Route::rule('role_auth', 'View/roleAuth', 'GET');
});

// 节点
Route::group('view', function(){
    Route::rule('node_index', 'View/nodeIndex', 'GET');
    Route::rule('node_save', 'View/nodeSave', 'GET');
    Route::rule('node_update', 'View/nodeUpdate', 'GET');
});

// 分类
Route::group('view', function(){
    Route::rule('category_index', 'View/categoryIndex', 'GET');
    Route::rule('category_save', 'View/categorySave', 'GET');
    Route::rule('category_update', 'View/categoryUpdate', 'GET');
});

// 文章分类
Route::group('view', function(){
    Route::rule('article_cate_index', 'View/articleCateIndex', 'GET');
    Route::rule('article_cate_save', 'View/articleCateSave', 'GET');
    Route::rule('article_cate_update', 'View/articleCateUpdate', 'GET');
});

// 文章管理
Route::group('view', function(){
    Route::rule('article_index', 'View/articleIndex', 'GET');
    Route::rule('article_save', 'View/articleSave', 'GET');
    Route::rule('article_update', 'View/articleUpdate', 'GET');
});

// 文章分类
Route::group('view', function(){
    Route::rule('news_cate_index', 'View/newsCateIndex', 'GET');
    Route::rule('news_cate_save', 'View/newsCateSave', 'GET');
    Route::rule('news_cate_update', 'View/newsCateUpdate', 'GET');
});

// 文章管理
Route::group('view', function(){
    Route::rule('news_index', 'View/newsIndex', 'GET');
    Route::rule('news_save', 'View/newsSave', 'GET');
    Route::rule('news_update', 'View/newsUpdate', 'GET');
});





















































































