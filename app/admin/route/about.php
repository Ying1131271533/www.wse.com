<?php


use think\facade\Route;

// 角色
Route::group('about', function(){
    Route::rule('', 'About/save', 'POST');
    Route::rule(':id', 'About/read', 'GET');
    Route::rule('', 'About/index', 'GET');
    Route::rule('', 'About/update', 'PUT');
    Route::rule(':id', 'About/delete', 'DELETE');
})->middleware([app\admin\middleware\IsLogin::class, app\admin\middleware\CheckAuth::class]);