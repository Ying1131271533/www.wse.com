<?php
// +----------------------------------------------------------------------
// | 控制台配置
// +----------------------------------------------------------------------
return [
    // 指令定义
    'commands' => [
        'tcp'        => 'app\common\command\swoole\TCP',
        'tcp_client' => 'app\common\command\swoole\TCPClient',
    ],
];
