<?php


use think\facade\Route;

// 跨境资讯
Route::group('news', function(){
    Route::rule('list', 'News/getNewsList', 'GET');
});