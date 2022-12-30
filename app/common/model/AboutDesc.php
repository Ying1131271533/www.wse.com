<?php

namespace app\common\model;

class AboutDesc extends BaseModel
{
    public function about()
    {
        return $this->belongsTo(About::class);
    }
}
