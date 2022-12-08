<?php

// +----------------------------------------------------------------------
// | 缓存设置
// +----------------------------------------------------------------------

return [
    // 默认缓存驱动

    // 命令行运行的程序 默认使用这里的配置？
    'default' => env('cache.driver', 'redis'),

    // 缓存连接方式配置
    'stores'  => [
        'file'     => [
            // 驱动方式
            'type'       => 'File',
            // 缓存保存目录
            'path'       => '../runtime/file/',
            // 缓存前缀
            'prefix'     => '',
            // 缓存有效期 0表示永久缓存
            'expire'     => cache_time('one_month'),
            // 缓存标签前缀
            'tag_prefix' => 'file:',
            // 序列化机制 例如 ['serialize', 'unserialize']
            'serialize'  => [],
        ],
        // 缓存邮箱/手机验证码
        'code'     => [
            // 驱动方式
            'type'       => 'File',
            // 缓存保存目录
            'path'       => '../runtime/code/',
            // 缓存前缀
            'prefix'     => '',
            // 缓存有效期 0表示永久缓存
            'expire'     => 300,
            // 缓存标签前缀
            'tag_prefix' => 'code:',
            // 序列化机制 例如 ['serialize', 'unserialize']
            'serialize'  => [],
        ],
        // redis
        'redis'    => [
            // 驱动方式
            'type'     => 'redis',
            // 服务器地址
            'host'     => config('app.redis.host'),
            // 'host'     => '127.0.0.1',
            // 'host'     => 'redis',
            // 密码.
            'password' => config('app.redis.password'),
            // 端口
            'port'     => config('app.redis.port'),
            // 库
            'select'   => 0,
            // 缓存有效期 0表示永久缓存
            'expire'   => null,
            // 'expire'   => cache_time('one_month'),
        ],
        // redis哨兵
        'sentinel' => [
            // 驱动方式
            'type'   => 'redis',
            // 服务器地址
            'host'   => config('app.redis.host'),
            // 缓存有效期 0表示永久缓存
            'expire' => cache_time('one_month'),
            // 端口
            'port'   => 26379,
        ],
        // memcahce
        'memcache' => [
            // 驱动方式
            'type'   => 'memcache',
            // 服务器地址
            'host'   => config('app.memcache.host'),
            // 端口
            'port'   => config('app.memcache.port'),
            // 缓存有效期 0表示memcache的最大缓存时间一个月
            'expire' => 0,
        ],
        // 更多的缓存连接
    ],
];
