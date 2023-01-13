<?php


use think\facade\Route;

// 跨境资讯
Route::group('about', function(){
    Route::rule('info/:id', 'About/getBasicInfo', 'GET')->pattern(['id' => '\d+']);
});