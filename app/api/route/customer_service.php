<?php


use think\facade\Route;

// 客服
Route::group('customer_service', function(){
    Route::rule('get_customer_serviceList', 'CustomerService/getCustomerServiceList', 'GET');
});