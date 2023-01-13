<?php

namespace app\common\model;

class ProductDesc extends BaseModel
{
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
