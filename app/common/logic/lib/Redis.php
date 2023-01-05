<?php

namespace app\common\logic\lib;

use think\cache\driver\Redis as DriverRedis;
use think\facade\Cache;

class Redis
{
    private $store = null;
    private $redis = null;

    public function __construct($store = 'redis')
    {
        $this->setStore($store);
        // 下面这个不能用setStore()这个方法，使用无效，好像又行了........
        $this->redis = new DriverRedis(config('cache.stores.' . $this->store));
    }

    public function set($key, $value, $ttl = null)
    {
        return Cache::store($this->store)->set($key, $value, $ttl);
    }

    public function drset($key, $value, $ttl = null)
    {
        return $this->redis->set($key, $value, $ttl);
    }

    public function get($key)
    {
        return Cache::store($this->store)->get($key);
    }

    public function keys($key)
    {
        return Cache::store($this->store)->keys($key);
    }

    public function drkeys($key)
    {
        return $this->redis->keys($key);
    }
    
    // 虽然写着删除缓存标签，但还是可以删除缓存的
    public function clearTag($key)
    {
        return Cache::store($this->store)->clearTag($key);
    }

    public function drclearTag($key)
    {
        return $this->redis->clearTag($key);
    }

    public function drget($key)
    {
        return $this->redis->get($key);
    }

    public function delete($key)
    {
        return Cache::store($this->store)->delete($key);
    }

    public function drdelete($key)
    {
        return $this->redis->delete($key);
    }

    // 事务
    public function multi()
    {
        return $this->redis->multi();
    }

    // 提交
    public function exec()
    {
        return $this->redis->exec();
    }

    // 回滚
    public function discard()
    {
        return $this->redis->discard();
    }

    // 缓存设置
    public function setStore($store)
    {
        $this->store = $store;
        return $this;
    }
}
