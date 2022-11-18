<?php

use think\facade\Route;

Route::group('article', function(){
    // 首页
    Route::rule('', 'Article/index', 'GET');
    // 文章详情
    Route::rule(':id', 'Article/detail', 'GET')->pattern(['id' => '\d+']);
});

Route::group('news', function(){
    // 公司新闻列表
    Route::rule('', 'Article/news', 'GET');
    // 新闻详情
    Route::rule(':id', 'Article/newsDetail', 'GET')->pattern(['id' => '\d+']);
});