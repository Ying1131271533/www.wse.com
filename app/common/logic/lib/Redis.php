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
    
    // 批量删除key，虽然写着删除缓存标签，但还是可以删除缓存的
    public function clearTag(array $keys)
    {
        return Cache::store($this->store)->clearTag($keys);
    }

    public function drclearTag(array $keys)
    {
        return $this->redis->clearTag($keys);
    }

    public function drget($key)
    {
        return $this->redis->get($key);
    }

    public function delete($key)
    {
        return Cache::store($this->store)->delete($key);
    }

    // 自增
    public function inc($key)
    {
        return Cache::store($this->store)->inc($key);
    }

    // 自减
    public function dec($key)
    {
        return Cache::store($this->store)->dec($key);
    }

    // 删除
    public function drdelete(string $key)
    {
        return $this->redis->drdelete($key);
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
