<?php
namespace app\admin\controller;

use app\admin\logic\Slides as SlidesLogic;
use app\common\lib\exception\Fail;
use app\common\lib\exception\Miss;
use app\common\model\Slides as SlidesModel;
use app\Request;

class Slides
{
    public function save(Request $request)
    {
        $params = $request->params;
        $slides = SlidesLogic::saveSlides($params);
        return success($slides);
    }
    
    public function read(int $id)
    {
        $slides = SlidesModel::with('category')->find($id);
        if(empty($slides)) throw new Miss();
        return success($slides);
    }

    // 列表
    public function index(Request $request)
    {
        $params          = $request->params;
        $params['page']  = $request->page;
        $params['limit'] = $request->limit;
        $adminList       = SlidesLogic::getSlidesList($params);
        return success($adminList);
    }

    public function update(Request $request)
    {
        $params = $request->params;
        $slides = SlidesLogic::saveSlides($params);
        return success($slides);
    }

    public function delete(int $id)
    {
        SlidesLogic::deleteById($id);
        return success('删除成功');
    }
}
