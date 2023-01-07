<?php


use think\facade\Route;

// 跨境资讯
Route::group('category', function(){
    Route::rule('get_category_list', 'Category/getCategoryList', 'GET');
});