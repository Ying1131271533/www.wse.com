<?php


use think\facade\Route;

// 跨境资讯
Route::group('article', function(){
    Route::rule('list', 'Article/getArticleList', 'GET');
});