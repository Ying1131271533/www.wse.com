<?php


use think\facade\Route;

// 角色
Route::group('slides', function(){
    Route::rule('', 'Slides/save', 'POST');
    Route::rule(':id', 'Slides/read', 'GET');
    Route::rule('', 'Slides/index', 'GET');
    Route::rule('', 'Slides/update', 'PUT');
    Route::rule(':id', 'Slides/delete', 'DELETE');
})->middleware([app\admin\middleware\IsLogin::class, app\admin\middleware\CheckAuth::class]);