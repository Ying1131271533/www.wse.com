<?php


use think\facade\Route;

// 角色
Route::group('about_cate', function(){
    Route::rule('', 'AboutCate/save', 'POST');
    Route::rule(':id', 'AboutCate/read', 'GET');
    Route::rule('', 'AboutCate/index', 'GET');
    Route::rule('', 'AboutCate/update', 'PUT');
    Route::rule(':id', 'AboutCate/delete', 'DELETE');
})->middleware([app\admin\middleware\IsLogin::class, app\admin\middleware\CheckAuth::class]);