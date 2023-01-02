<?php

namespace app\common\model;

class Category extends BaseModel
{
    public function slides()
    {
        return $this->hasMany(Slides::class);
    }
}
