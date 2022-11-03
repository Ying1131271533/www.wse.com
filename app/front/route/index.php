<?php

use think\facade\Route;

Route::group('', function(){
    // 首页
    Route::rule('', 'Index/index', 'GET');
});