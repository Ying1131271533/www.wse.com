<?php

use think\facade\Route;

Route::group('', function(){
    // 首页
    Route::rule('', 'Index/index', 'GET');
    // 关于我们
    Route::rule('about', 'Index/about', 'GET');
    // 企业文化
    Route::rule('culture', 'Index/culture', 'GET');
    // 人才招聘
    Route::rule('job', 'Index/job', 'GET');
    // 联系我们
    Route::rule('contact', 'Index/contact', 'GET');
});