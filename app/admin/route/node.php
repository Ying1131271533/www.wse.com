<?php


use think\facade\Route;

// 角色
Route::group('node', function(){
    Route::rule('', 'Node/save', 'POST');
    Route::rule(':id', 'Node/read', 'GET');
    Route::rule('', 'Node/index', 'GET');
    Route::rule('', 'Node/update', 'PUT');
    Route::rule(':id', 'Node/delete', 'DELETE');
})->middleware(app\admin\middleware\IsLogin::class);