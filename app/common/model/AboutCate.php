<?php

namespace app\common\model;

class AboutCate extends BaseModel
{
    public function about()
    {
        return $this->hasMany(About::class);
    }
}
