<?php

use think\facade\Route;

Route::group('product', function(){
    // 首页
    Route::rule('', 'Product/index', 'GET');
    // 物流详情
    Route::rule(':id', 'Product/detail', 'GET')->pattern(['id' => '\d+']);
});