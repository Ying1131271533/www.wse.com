<?php
namespace app\api\controller;

use app\api\logic\Product as ProductLogic;
use app\Request;

class Product
{
    public function getProductList(Request $request)
    {
        $page = $request->page;
        $limit = $request->limit;
        $platformList = ProductLogic::getProductList($page, $limit);
        return success($platformList);
    }

    public function getBasicInfo(int $id)
    {
        $platform = ProductLogic::getBasicInfoById($id);
        return success($platform);
    }
}
