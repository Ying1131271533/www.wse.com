<?php


use think\facade\Route;

// 客服
Route::group('customer_service', function(){
    Route::rule('list', 'CustomerService/getCustomerServiceList', 'GET');
});