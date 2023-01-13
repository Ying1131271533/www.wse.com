<?php

namespace app\common\model;

class PlatformDesc extends BaseModel
{
    public function platform()
    {
        return $this->belongsTo(Platform::class);
    }
}
