<?php

namespace app\common\model;

use think\Model;
use think\model\concern\SoftDelete;

class ArticleDesc extends Model
{
    // 软删除
    use SoftDelete;
    protected $deleteTime = 'delete_time';

    public function article()
    {
        return $this->hasOne(Article::class);
    }
}
