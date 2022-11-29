<?php

use think\facade\Route;

Route::group('index', function(){
    // 首页
    Route::rule('index', 'Index/index', 'GET');
});