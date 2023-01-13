<?php


use think\facade\Route;

// 角色
Route::group('product', function(){
    Route::rule('', 'Product/save', 'POST');
    Route::rule(':id', 'Product/read', 'GET');
    Route::rule('', 'Product/index', 'GET');
    Route::rule('', 'Product/update', 'PUT');
    Route::rule(':id', 'Product/delete', 'DELETE');
})->middleware([app\admin\middleware\IsLogin::class, app\admin\middleware\CheckAuth::class]);