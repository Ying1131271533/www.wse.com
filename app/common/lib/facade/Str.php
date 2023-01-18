<?php

namespace app\common\lib\facade;

use think\Facade;

/**
 * Class Str 静态
 * @package app\common\lib\facade
 * @mixin \app\common\logic\lib\Str
 */
class Str extends Facade
{
    protected static function getFacadeClass()
    {
        return \app\common\lib\Str::class;
    }
}
