<?php


use think\facade\Route;

// 角色
Route::group('category', function(){
    Route::rule('', 'Category/save', 'POST');
    Route::rule(':id', 'Category/read', 'GET');
    Route::rule('', 'Category/index', 'GET');
    Route::rule('', 'Category/update', 'PUT');
    Route::rule(':id', 'Category/delete', 'DELETE');
})->middleware([app\admin\middleware\IsLogin::class, app\admin\middleware\CheckAuth::class]);