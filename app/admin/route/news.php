<?php


use think\facade\Route;

// 角色
Route::group('news', function(){
    Route::rule('', 'News/save', 'POST');
    Route::rule(':id', 'News/read', 'GET');
    Route::rule('', 'News/index', 'GET');
    Route::rule('', 'News/update', 'PUT');
    Route::rule(':id', 'News/delete', 'DELETE');
})->middleware([app\admin\middleware\IsLogin::class, app\admin\middleware\CheckAuth::class]);