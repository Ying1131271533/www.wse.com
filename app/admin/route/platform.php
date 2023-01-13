<?php


use think\facade\Route;

// 角色
Route::group('platform', function(){
    Route::rule('', 'Platform/save', 'POST');
    Route::rule(':id', 'Platform/read', 'GET');
    Route::rule('', 'Platform/index', 'GET');
    Route::rule('', 'Platform/update', 'PUT');
    Route::rule(':id', 'Platform/delete', 'DELETE');
})->middleware([app\admin\middleware\IsLogin::class, app\admin\middleware\CheckAuth::class]);