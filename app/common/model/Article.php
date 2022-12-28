<?php

namespace app\common\model;

class Article extends BaseModel
{
    public function cate()
    {
        return $this->belongsTo(ArticleCate::class);
    }
}
