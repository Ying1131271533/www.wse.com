<?php


use think\facade\Route;

// 跨境资讯
Route::group('article', function(){
    Route::rule('get_article_list', 'Article/getArticleList', 'GET');
    Route::rule('info/:id', 'Article/getBasicInfo', 'GET')->pattern(['id' => '\d+']);
});