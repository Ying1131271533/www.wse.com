<?php


use think\facade\Route;

// 跨境资讯
Route::group('slides', function(){
    Route::rule('get_slieds_list/:category_id', 'Slides/getSlidesList', 'GET')->pattern(['category_id' => '\d+']);
});