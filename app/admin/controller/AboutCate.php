<?php
namespace app\admin\controller;

use app\admin\logic\AboutCate as AboutCateLogic;
use app\common\lib\exception\Miss;
use app\common\model\AboutCate as AboutCateModel;
use app\Request;

class AboutCate
{
    public function save(Request $request)
    {
        $params = $request->params;
        $aboutCate = AboutCateLogic::saveAboutCate($params);
        return success($aboutCate);
    }

    public function index()
    {
        $aboutCateList = AboutCateLogic::getAboutCateList();
        return success($aboutCateList);
    }

    public function read(int $id)
    {
        $aboutCate = AboutCateModel::find($id);
        if(empty($aboutCate)) throw new Miss();
        return success($aboutCate);
    }

    public function update(Request $request)
    {
        $params = $request->params;
        $aboutCate = AboutCateLogic::saveAboutCate($params);
        return success($aboutCate);
    }

    public function delete(int $id)
    {
        AboutCateLogic::deleteAboutCate($id);
        return success('删除成功');
    }
}
