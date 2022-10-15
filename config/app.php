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
    'default_app'      => 'index',
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
    'show_error_msg'   => false,

    /************** 自定义配置 **************/

    // 页码
    'page'             => 1,
    'size'             => 20,

    // redis连接配置
    'redis'            => [
        'host'     => 'redis',
        'password' => 'Ym-12]i4!gDal^Jc/3@n.c^Mh',
        'port'     => 6379,
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
    'swoole'    => [
        'host'     => '127.0.0.1',
        'port'     => 9501,
    ],
];
