<?php
namespace app\api\controller;

use app\api\logic\About as AboutLogic;

class About
{
    public function getBasicInfo(int $id)
    {
        $about = AboutLogic::getBasicInfoById($id);
        return success($about);
    }
}
