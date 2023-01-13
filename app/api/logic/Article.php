<?php
namespace app\api\logic;

use app\common\lib\exception\Fail;
use app\common\lib\exception\Miss;
use app\common\model\Article as ArticleModel;

class Article
{
    public static function getArticleList(int $page, int $limit)
    {
        $articleList = ArticleModel::getPageList(
            $page, $limit,
            ['status' => 1],
            [],
            ['sort' => 'desc', 'id' => 'desc']
        );
        return $articleList;
    }

    public static function getBasicInfoById(int $id)
    {
        $cache_time = cache_time();
        $article = ArticleModel::with(['desc' => function($query) {
            $query->field('content, article_id');
        }, 'cate' => function($query) {
            $query->field('id, cate_name');
        }])
            ->where('status', 1)
            ->withCache('cate', 'article:' . $id.':cate', $cache_time)
            ->withCache('desc', 'article:' . $id.':desc', $cache_time)
            ->cache('article:' . $id.':info', $cache_time)
            ->field('id, title, author, image, description, view, article_cate_id')
            // ->withoutField('url, sort, status, update_time, create_time, delete_time')
            ->find($id);
        if (empty($article)) throw new Miss();
        // 浏览量加一
        $article->inc('view')->update();
        return $article;
    }
}
