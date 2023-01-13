<?php

use think\facade\Route;

Route::group('upload', function(){
    // 上传文件
    Route::rule('file', 'Upload/file', 'POST');
});