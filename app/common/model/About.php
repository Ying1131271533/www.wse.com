<?php

namespace app\common\model;

class About extends BaseModel
{
    public function cate()
    {
        return $this->belongsTo(AboutCate::class);
    }

    public function desc()
    {
        return $this->hasOne(AboutDesc::class);
    }

    public static function getAboutList($where, $page, $limit)
    {
        return self::with(['cate'])
        ->where($where)
        ->order('id', 'asc')
        ->paginate($limit, false, ['page' => $page])
        ->toArray();
    }
}
