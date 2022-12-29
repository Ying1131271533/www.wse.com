<?php
namespace app\admin\controller;

use app\admin\logic\ArticleCate as ArticleCateLogic;
use app\common\lib\exception\Miss;
use app\common\model\ArticleCate as ArticleCateModel;
use app\Request;

class NewsCate
{
    public function save(Request $request)
    {
        $params = $request->params;
        $aritcleCate = ArticleCateLogic::saveArticleCate($params);
        return success($aritcleCate);
    }

    public function index()
    {
        $aritcleCateList = ArticleCateLogic::getArticleCateList();
        return success($aritcleCateList);
    }

    public function read(int $id)
    {
        $aritcleCate = ArticleCateModel::find($id);
        if(empty($aritcleCate)) throw new Miss();
        return success($aritcleCate);
    }

    public function update(Request $request)
    {
        $params = $request->params;
        $aritcleCate = ArticleCateLogic::saveArticleCate($params);
        return success($aritcleCate);
    }

    public function delete(int $id)
    {
        ArticleCateLogic::deleteArticleCate($id);
        return success('删除成功');
    }
}
