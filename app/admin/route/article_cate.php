<?php


use think\facade\Route;

// 角色
Route::group('article_cate', function(){
    Route::rule('', 'ArticleCate/save', 'POST');
    Route::rule(':id', 'ArticleCate/read', 'GET');
    Route::rule('', 'ArticleCate/index', 'GET');
    Route::rule('', 'ArticleCate/update', 'PUT');
    Route::rule(':id', 'ArticleCate/delete', 'DELETE');
})->middleware([app\admin\middleware\IsLogin::class, app\admin\middleware\CheckAuth::class]);