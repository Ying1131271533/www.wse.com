<?php

namespace app\common\model;

class ArticleCate extends BaseModel
{
    public function articles()
    {
        return $this->hasMany(Article::class);
    }
}
