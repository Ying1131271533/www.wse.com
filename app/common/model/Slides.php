<?php

namespace app\common\model;

class Slides extends BaseModel
{
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public static function getSlidesList($where, $page, $limit)
    {
        return self::with('category')
        ->where($where)
        ->order('id', 'asc')
        ->paginate($limit, false, ['page' => $page])
        ->toArray();
    }
}
