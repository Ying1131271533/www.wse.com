<?php

namespace app\common\model;

class Article extends BaseModel
{
    public function cate()
    {
        return $this->belongsTo(ArticleCate::class);
    }

    public function desc()
    {
        return $this->hasOne(ArticleDesc::class);
    }

    public static function getArticleList($where, $page, $limit)
    {
        return self::with(['cate'])
        ->where($where)
        ->order('id', 'desc')
        ->paginate($limit, false, ['page' => $page])
        ->toArray();
    }
}
