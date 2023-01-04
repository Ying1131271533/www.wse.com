<?php


use think\facade\Route;

// 跨境资讯
Route::group('category', function(){
    Route::rule('list', 'Category/getCategoryList', 'GET');
});