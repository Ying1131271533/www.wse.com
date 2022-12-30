<?php

namespace app\common\model;

class SlideImgs extends BaseModel
{
    public function slide()
    {
        return $this->belongsTo(Slide::class);
    }
}
