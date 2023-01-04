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
        $article = ArticleModel::with(['desc', 'cate'])
            ->withCache('cate', 'article:' . $id.':cate', cache_time())
            ->withCache('desc', 'article:' . $id.':desc', cache_time())
            ->cache('article:' . $id.':info', cache_time())
            ->find($id);
        if (empty($article)) throw new Miss();
        return success($article);
    }
}
