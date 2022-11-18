<?php

use think\facade\Route;

Route::group('platform', function(){
    // 首页
    Route::rule('', 'platform/index', 'GET');
    // 物流详情
    Route::rule(':id', 'platform/detail', 'GET')->pattern(['id' => '\d+']);
});