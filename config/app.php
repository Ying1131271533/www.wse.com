<?php
// +----------------------------------------------------------------------
// | 应用设置
// +----------------------------------------------------------------------

return [
    // 应用地址
    'app_host'         => env('app.host', ''),
    // 应用的命名空间
    'app_namespace'    => '',
    // 是否启用路由
    'with_route'       => true,
    // 默认应用
    'default_app'      => 'front',
    // 默认时区
    'default_timezone' => 'Asia/Shanghai',

    // 应用映射（自动多应用模式有效）
    'app_map'          => [],
    // 域名绑定（自动多应用模式有效）
    'domain_bind'      => [
        'www'   => 'front',
        'admin' => 'admin',
        'api'   => 'api',
        'm'     => 'mobile',
    ],
    // 禁止URL访问的应用列表（自动多应用模式有效）
    'deny_app_list'    => [],

    // 异常页面的模板文件
    'exception_tmpl'   => app()->getThinkPath() . 'tpl/think_exception.tpl',

    // 错误显示信息,非调试模式有效
    'error_message'    => '页面错误！请稍后再试～',
    // 显示错误信息
    'show_error_msg'   => true,

    
    /************** 自定义配置 **************/


    // 可以上传的文件类型和上传规则
    'upload_file_type' => [
        // 单张图片
        'image'  => ['image' => 'fileSize:2097152|fileExt:jpg,jpeg,gif,png,bmp'],
        // 多张图片
        'images' => ['image' => 'fileSize:2097152|fileExt:jpg,jpeg,gif,png,bmp'],
        // excel表格
        'excel'  => ['file' => 'fileSize:2097152|fileExt:xls,xlsx'],
        // word文档
        'word'   => ['file' => 'fileSize:2097152|fileExt:doc'],
    ],

    // 页码
    'page'             => 1,
    'limit'            => 10,

    // redis连接配置
    'redis'            => [
        'host' => '127.0.0.1', // 草啊！这里不能写 localhost 啊！！！！！
        // 'host'     => 'redis',
        'password' => '',
        // 'password' => 'Ym-12]i4!gDal^Jc/3@n.c^Mh',
        'port' => 6379,
        'select' => 0,
    ],

    // memcache连接配置
    'memcache'         => [
        'host'     => 'memcache',
        'password' => '',
        'port'     => 11211,
    ],

    // rabbitmq连接配置
    'rabbitmq'         => [
        'host'     => 'rabbitmq',
        'port'     => 5672,
        'login'    => 'admin',
        'password' => 'Pt-89]j9+qLai^Rc/3@n|c^Um',
        'vhost'    => '/',
    ],

    // elasticsearch连接配置
    'elasticsearch'    => [
        'http'     => ['http://elasticsearch:9200'],
        'https'    => ['https://elasticsearch:9200'],
        'username' => 'elastic',
        'password' => 'HnBSVNqu2fTDJH*SPL4K',
    ],
    // swoole连接配置
    'swoole'           => [
        'host' => '127.0.0.1',
        'port' => 9501,
    ],
];
