<?php
namespace app\admin\controller;

use app\admin\logic\Article as ArticleLogic;
use app\common\lib\exception\Fail;
use app\common\lib\exception\Miss;
use app\common\model\Article as ArticleModel;
use app\Request;

class Article
{
    public function save(Request $request)
    {
        $params = $request->params;
        $article = ArticleLogic::saveArticle($params);
        return success($article);
    }
    
    public function read(int $id)
    {
        $article = ArticleModel::with(['cate', 'desc'])->find($id);
        if(empty($article)) throw new Miss();
        return success($article);
    }

    // 列表
    public function index(Request $request)
    {
        $params          = $request->params;
        $params['page']  = $request->page;
        $params['limit'] = $request->limit;
        $adminList       = ArticleLogic::getArticleList($params);
        return layui($adminList);
    }

    public function update(Request $request)
    {
        $params = $request->params;
        $article = ArticleLogic::saveArticle($params);
        return success($article);
    }

    public function delete(int $id)
    {
        ArticleLogic::deleteById($id);
        return success('删除成功');
    }
}
