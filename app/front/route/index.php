<?php

use think\facade\Route;

Route::group('', function(){
    // 首页
    Route::rule('', 'Index/index', 'GET');
    // 关于我们
    Route::rule('about/:id', 'Index/about', 'GET')->pattern(['id' => '\d+']);
    // 联系我们
    Route::rule('contact', 'Index/contact', 'GET');
});