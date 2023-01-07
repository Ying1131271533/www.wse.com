<?php
namespace app\api\controller;

use app\api\logic\Article as ArticleLogic;
use app\common\lib\exception\Miss;
use app\common\model\Article as ArticleModel;
use app\Request;

class Article
{
    public function getArticleList(Request $request)
    {
        $page = $request->page;
        $limit = $request->limit;
        $articleList = ArticleLogic::getArticleList($page, $limit);
        return success($articleList);
    }

    public function getBasicInfo(int $id)
    {
        $article = ArticleLogic::getBasicInfoById($id);
        return success($article);
    }
}
