<?php

namespace app\common\model;

class ArticleDesc extends BaseModel
{
    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}
