<?php
namespace app\admin\controller;

use app\admin\logic\Slide as SlideLogic;
use app\common\lib\exception\Fail;
use app\common\lib\exception\Miss;
use app\common\model\Slide as SlideModel;
use app\Request;

class Slide
{
    public function save(Request $request)
    {
        $params = $request->params;
        $slide = SlideLogic::saveSlide($params);
        return success($slide);
    }
    
    public function read(int $id)
    {
        $slide = SlideModel::with(['cate', 'desc'])->find($id);
        if(empty($slide)) throw new Miss();
        return success($slide);
    }

    // 列表
    public function index(Request $request)
    {
        $params          = $request->params;
        $params['page']  = $request->page;
        $params['limit'] = $request->limit;
        $adminList       = SlideLogic::getSlideList($params);
        return success($adminList);
    }

    public function update(Request $request)
    {
        $params = $request->params;
        $slide = SlideLogic::saveSlide($params);
        return success($slide);
    }

    public function delete(int $id)
    {
        SlideLogic::deleteById($id);
        return success('删除成功');
    }
}
