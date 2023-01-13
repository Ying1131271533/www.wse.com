<?php

namespace app\common\model;

class Product extends BaseModel
{
    public function desc()
    {
        return $this->hasOne(ProductDesc::class);
    }
}
