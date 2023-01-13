<?php

namespace app\common\model;

class Platform extends BaseModel
{
    public function desc()
    {
        return $this->hasOne(PlatformDesc::class);
    }
}
