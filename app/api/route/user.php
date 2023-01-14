<?php

use think\facade\Route;

// 管理员
Route::group('user', function(){
    // 登录
    Route::rule('login', 'User/login', 'POST');
    // 注册
    Route::rule('register', 'User/register', 'POST');
});

Route::group('user', function(){
    // 验证登录
    Route::rule('is_login', 'User/isLogin', 'POST');
    // 退出登录
    Route::rule('logout', 'User/logout', 'POST');
    // 获取用户
    Route::rule('get_user_by_token', 'User/getUserByToken', 'POST');
    // 根据id获取用户
    Route::rule('get_user_by_id', 'User/getUserById', 'POST');
    // 用户主页
    Route::rule('index', 'User/index', 'GET');
    // 获取邀请码
    Route::rule('get_invitation_code', 'User/getInvitationCode', 'GET');
})->middleware(app\user\middleware\IsLogin::class);