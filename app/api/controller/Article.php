<?php
namespace app\api\controller;

use app\common\lib\exception\Miss;
use app\common\model\Article as ArticleModel;
use app\Request;

class Article
{
    public function getArticleList(Request $request)
    {
        $params['page']  = $request->page;
        $params['limit'] = $request->limit;
        $articleList     = ArticleModel::getPageList(
            $params['page'], $params['limit'],
            ['status' => 1],
            [],
            ['sort' => 'desc', 'id' => 'desc']
        );
        return success($articleList);
    }

    public function getBasicInfo(int $id)
    {
        $article = ArticleModel::with(['desc' => function($query) {
            $query->field('content, article_id');
        }, 'cate' => function($query) {
            $query->field('id, cate_name');
        }])
            ->withCache('cate', 'article:' . $id.':cate', cache_time())
            ->withCache('desc', 'article:' . $id.':desc', cache_time())
            ->cache('article:' . $id.':info', cache_time())
            ->field('id, title, author, image, description, view, article_cate_id')
            // ->withoutField('url, sort, status, update_time, create_time, delete_time')
            ->find($id);
        if (empty($article)) throw new Miss();
        return success($article);
    }
}
