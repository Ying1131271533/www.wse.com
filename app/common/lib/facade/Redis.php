<?php

namespace app\common\lib\facade;

use think\Facade;

/**
 * Class Redis 静态
 * @package app\common\lib\facade
 * @mixin \app\common\logic\lib\Redis
 */
class Redis extends Facade
{
    protected static function getFacadeClass()
    {
        return \app\common\logic\lib\Redis::class;
    }
}
