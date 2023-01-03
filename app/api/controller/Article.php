<?php
namespace app\api\controller;

use app\common\model\Article as ArticleModel;
use app\Request;

class Article
{
    public function getArticleList(Request $request)
    {
        $params['page']  = $request->page;
        $params['limit'] = $request->limit;
        $articleList = ArticleModel::getPageList(
            $params['page'], $params['limit'],
            [],
            [],
            ['sort' => 'desc', 'id' => 'desc']
        );
        return success($articleList);
    }
}
