<?php

use think\facade\Route;

Route::group('ajax', function(){
    // 修改数据字段的值
    Route::rule('update_field_value', 'Ajax/updateFieldValue', 'PUT');
})->middleware(app\admin\middleware\IsLogin::class);