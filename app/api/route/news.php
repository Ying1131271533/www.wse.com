<?php


use think\facade\Route;

// 跨境资讯
Route::group('news', function(){
    Route::rule('list', 'News/getNewsList', 'GET');
    Route::rule('info/:id', 'News/getBasicInfo', 'GET')->pattern(['id' => '\d+']);
});