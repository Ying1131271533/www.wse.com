<?php
namespace app\api\controller;

use app\api\logic\Platform as PlatformLogic;
use app\Request;

class Platform
{
    public function getPlatformList(Request $request)
    {
        $page = $request->page;
        $limit = $request->limit;
        $platformList = PlatformLogic::getPlatformList($page, $limit);
        return success($platformList);
    }

    public function getBasicInfo(int $id)
    {
        $platform = PlatformLogic::getBasicInfoById($id);
        return success($platform);
    }
}
