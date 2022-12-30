<?php
namespace app\admin\controller;

use app\admin\logic\About as AboutLogic;
use app\common\lib\exception\Fail;
use app\common\lib\exception\Miss;
use app\common\model\About as AboutModel;
use app\Request;

class About
{
    public function save(Request $request)
    {
        $params = $request->params;
        $about = AboutLogic::saveAbout($params);
        return success($about);
    }
    
    public function read(int $id)
    {
        $about = AboutModel::with(['cate', 'desc'])->find($id);
        if(empty($about)) throw new Miss();
        return success($about);
    }

    // 列表
    public function index(Request $request)
    {
        $params          = $request->params;
        $params['page']  = $request->page;
        $params['limit'] = $request->limit;
        $adminList       = AboutLogic::getAboutList($params);
        return success($adminList);
    }

    public function update(Request $request)
    {
        $params = $request->params;
        $about = AboutLogic::saveAbout($params);
        return success($about);
    }

    public function delete(int $id)
    {
        AboutLogic::deleteById($id);
        return success('删除成功');
    }
}
