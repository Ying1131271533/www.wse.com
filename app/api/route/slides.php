<?php


use think\facade\Route;

// 跨境资讯
Route::group('slides', function(){
    Route::rule('list/:category_id', 'Slides/getSlidesList', 'GET');
});