<?php


use think\facade\Route;

// 角色
Route::group('news_cate', function(){
    Route::rule('', 'NewsCate/save', 'POST');
    Route::rule(':id', 'NewsCate/read', 'GET');
    Route::rule('', 'NewsCate/index', 'GET');
    Route::rule('', 'NewsCate/update', 'PUT');
    Route::rule(':id', 'NewsCate/delete', 'DELETE');
})->middleware([app\admin\middleware\IsLogin::class, app\admin\middleware\CheckAuth::class]);