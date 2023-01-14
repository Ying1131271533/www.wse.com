<?php
namespace app\api\controller;

use app\api\logic\About as AboutLogic;
use app\common\lib\Hashids;
use app\Request;

class About
{
    public function getBasicInfo(int $id)
    {
        $about = AboutLogic::getBasicInfoById($id);
        return success($about);
    }
}
