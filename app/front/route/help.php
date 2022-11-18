<?php

use think\facade\Route;

Route::group('help', function(){
    // 帮助中心
    Route::rule(':id', 'help/index', 'GET')->pattern(['id' => '\d+']);
    // 详情
    Route::rule('detail/:id', 'help/detail', 'GET')->pattern(['id' => '\d+']);
});


