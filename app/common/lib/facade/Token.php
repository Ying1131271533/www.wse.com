<?php

namespace app\common\lib\facade;

use think\Facade;

/**
 * Class Token 静态
 * @package app\common\lib\facade
 * @mixin \app\common\logic\lib\Token
 */
class Token extends Facade
{
    protected static function getFacadeClass()
    {
        return \app\common\lib\Token::class;
    }
}
