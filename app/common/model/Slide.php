<?php

namespace app\common\model;

class Slide extends BaseModel
{
    public function imgs()
    {
        return $this->hasMany(SlideImgs::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public static function getSlideList($where, $page, $limit)
    {
        return self::with(['category', 'imgs'])
        ->where($where)
        ->order('id', 'asc')
        ->paginate($limit, false, ['page' => $page])
        ->toArray();
    }
}
