<?php

namespace app\common\model;

class NewsCate extends BaseModel
{
    public function news()
    {
        return $this->hasMany(News::class);
    }
}
