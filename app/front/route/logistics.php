<?php

use think\facade\Route;

Route::group('logistics', function(){
    // 首页
    Route::rule('', 'Logistics/index', 'GET');
    // 物流详情
    Route::rule(':id', 'Logistics/detail', 'GET')->pattern(['id' => '\d+']);
});