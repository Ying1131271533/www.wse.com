<?php

use think\facade\Route;

// 跨境资讯
Route::group('platform', function () {
    Route::rule('get_platform_list', 'Platform/getPlatformList', 'GET');
    Route::rule('info/:id', 'Platform/getBasicInfo', 'GET')->pattern(['id' => '\d+']);
});
