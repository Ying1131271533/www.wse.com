<?php

use think\facade\Route;

// 跨境资讯
Route::group('product', function () {
    Route::rule('get_product_list', 'Product/getProductList', 'GET');
    Route::rule('info/:id', 'Product/getBasicInfo', 'GET')->pattern(['id' => '\d+']);
});
