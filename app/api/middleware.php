<?php
// 全局中间件定义文件
return [
    // 跨域请求支持
    // \think\middleware\AllowCrossDomain::class,
    [
        \think\middleware\AllowCrossDomain::class,
        [
            [
                // 请求头部允许加入access-token
                'Access-Control-Allow-Headers' => 'Authorization, Content-Type, If-Match, If-Modified-Since, If-None-Match, If-Unmodified-Since, X-CSRF-TOKEN, X-Requested-With, access-token',
            ],
        ],
    ],
];
