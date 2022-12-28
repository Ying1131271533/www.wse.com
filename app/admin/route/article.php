<?php


use think\facade\Route;

// 角色
Route::group('article', function(){
    Route::rule('', 'Article/save', 'POST');
    Route::rule(':id', 'Article/read', 'GET');
    Route::rule('', 'Article/index', 'GET');
    Route::rule('', 'Article/update', 'PUT');
    Route::rule(':id', 'Article/delete', 'DELETE');
})->middleware([app\admin\middleware\IsLogin::class, app\admin\middleware\CheckAuth::class]);