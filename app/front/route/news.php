<?php

use think\facade\Route;

Route::group('news', function(){
    // 公司新闻列表
    Route::rule('', 'News/index', 'GET');
    // 新闻详情
    Route::rule(':id', 'News/detail', 'GET')->pattern(['id' => '\d+']);
});