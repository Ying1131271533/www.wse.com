<?php

namespace app\common\model;

class NewsDesc extends BaseModel
{
    public function news()
    {
        return $this->belongsTo(News::class);
    }
}
