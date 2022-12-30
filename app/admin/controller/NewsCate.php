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
        $aritcleCate = NewsCateLogic::saveNewsCate($params);
        return success($aritcleCate);
    }

    public function index()
    {
        $aritcleCateList = NewsCateLogic::getNewsCateList();
        return success($aritcleCateList);
    }

    public function read(int $id)
    {
        $aritcleCate = NewsCateModel::find($id);
        if(empty($aritcleCate)) throw new Miss();
        return success($aritcleCate);
    }

    public function update(Request $request)
    {
        $params = $request->params;
        $aritcleCate = NewsCateLogic::saveNewsCate($params);
        return success($aritcleCate);
    }

    public function delete(int $id)
    {
        NewsCateLogic::deleteNewsCate($id);
        return success('删除成功');
    }
}
