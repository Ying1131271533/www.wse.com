<?php
namespace app\admin\controller;

use app\admin\logic\Platform as PlatformLogic;
use app\common\lib\exception\Fail;
use app\common\lib\exception\Miss;
use app\common\model\Platform as PlatformModel;
use app\Request;

class Platform
{
    public function save(Request $request)
    {
        $params = $request->params;
        $platform = PlatformLogic::savePlatform($params);
        return success($platform);
    }
    
    public function read(int $id)
    {
        $platform = PlatformModel::with(['desc'])->find($id);
        if(empty($platform)) throw new Miss();
        return success($platform);
    }

    // 列表
    public function index(Request $request)
    {
        $params          = $request->params;
        $params['page']  = $request->page;
        $params['limit'] = $request->limit;
        $adminList       = PlatformLogic::getPlatformList($params);
        return layui($adminList);
    }

    public function update(Request $request)
    {
        $params = $request->params;
        $platform = PlatformLogic::savePlatform($params);
        return success($platform);
    }

    public function delete(int $id)
    {
        PlatformLogic::deleteById($id);
        return success('删除成功');
    }
}
