<?php


use think\facade\Route;

// 角色
Route::group('customer_service', function(){
    Route::rule('', 'CustomerService/save', 'POST');
    Route::rule(':id', 'CustomerService/read', 'GET');
    Route::rule('', 'CustomerService/index', 'GET');
    Route::rule('', 'CustomerService/update', 'PUT');
    Route::rule(':id', 'CustomerService/delete', 'DELETE');
})->middleware([app\admin\middleware\IsLogin::class, app\admin\middleware\CheckAuth::class]);