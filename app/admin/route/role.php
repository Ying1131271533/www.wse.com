<?php


use think\facade\Route;

// 角色
Route::group('role', function(){
    Route::rule('', 'Role/save', 'POST');
    Route::rule(':id', 'Role/read', 'GET');
    Route::rule('', 'Role/index', 'GET');
    Route::rule('', 'Role/update', 'PUT');
    Route::rule(':id', 'Role/delete', 'DELETE');
})->middleware(app\admin\middleware\IsLogin::class);