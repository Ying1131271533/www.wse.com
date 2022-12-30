<?php
namespace app\admin\controller;

use app\admin\logic\NewsCate as NewsCateLogic;
use app\common\lib\exception\Miss;
use app\common\model\NewsCate as NewsCateModel;
use app\Request;

class NewsCate
{
    public function save(Request $request)
    {
        $params = $request->params;
        $newsCate = NewsCateLogic::saveNewsCate($params);
        return success($newsCate);
    }

    public function index()
    {
        $newsCateList = NewsCateLogic::getNewsCateList();
        return success($newsCateList);
    }

    public function read(int $id)
    {
        $newsCate = NewsCateModel::find($id);
        if(empty($newsCate)) throw new Miss();
        return success($newsCate);
    }

    public function update(Request $request)
    {
        $params = $request->params;
        $newsCate = NewsCateLogic::saveNewsCate($params);
        return success($newsCate);
    }

    public function delete(int $id)
    {
        NewsCateLogic::deleteNewsCate($id);
        return success('删除成功');
    }
}
