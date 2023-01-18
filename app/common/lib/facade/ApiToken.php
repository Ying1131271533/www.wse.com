<?php

namespace app\common\lib\facade;

use think\Facade;

/**
 * Class ApiToken 静态
 * @package app\common\lib\facade
 * @mixin \app\common\logic\lib\ApiToken
 */
class ApiToken extends Facade
{
    protected static function getFacadeClass()
    {
        return \app\common\lib\ApiToken::class;
    }
}
