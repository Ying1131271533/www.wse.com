<?php

namespace app\common\model;

use think\model;

use think\model\concern\SoftDelete;

abstract class BaseModel extends model
{
    // 软删除
    use SoftDelete;
    protected $deleteTime = 'delete_time';
    
    // 开启自动写入时间戳字段，自动写入create_time和update_time两个字段的值
    protected $autoWriteTimestamp = true;

    // 隐藏字段
    protected $hidden = [
        // 'passowrd',
        // 'create_time',
        // 'update_time',
        'delete_time',
    ];
    // 获取被隐藏数据
    // halt($user->getData());
    // 获取被隐藏的字段
    // halt($user->getData('name'));

    // 获取分页数据 - admin使用
    // public static function getPageData(int $page = 1, int $size = 30, string $order = 'id')
    // {
    //     return self::order($order, 'desc')->paginate($size, false, ['page' => $page]);
    // }
    
    // 获取分页数据 - api使用
    public static function getPageList(int $page = 1, int $limit = 30, array $where = [], array $without_field = [], array $order = ['id' => 'desc'])
    {
        return self::where($where)
        ->order($order)
        ->withoutField($without_field)
        ->paginate($limit, false, ['page' => $page])
        ->toArray();
    }
}
