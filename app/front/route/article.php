<?php

use think\facade\Route;

Route::group('article', function(){
    // 首页
    Route::rule('', 'Article/index', 'GET');
    // 文章详情
    Route::rule(':id', 'Article/detail', 'GET')->pattern(['id' => '\d+']);
});
