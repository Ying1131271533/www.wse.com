<?php

namespace app\common\lib;

use app\common\lib\facade\Redis;

class ApiToken
{
    public function getToken()
    {
        return request()->header('access-token');
    }

    public function getUser()
    {
        return Redis::get(config('redis.token_api') . $this->getToken());
    }

    public function getUid()
    {
        return $this->getUser()['id'];
    }

    public function deleteToken()
    {
        return Redis::delete(config('redis.token_api') . $this->getToken());
    }
}
