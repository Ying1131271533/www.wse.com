<?php

namespace app\common\model;

class News extends BaseModel
{
    public function cate()
    {
        return $this->belongsTo(NewsCate::class);
    }

    public function desc()
    {
        return $this->hasOne(NewsDesc::class);
    }

    public static function getNewsList($where, $page, $limit)
    {
        return self::with(['cate'])
        ->where($where)
        ->order('id', 'desc')
        ->paginate($limit, false, ['page' => $page])
        ->toArray();
    }
}
