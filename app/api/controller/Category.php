<?php
namespace app\api\controller;

use app\api\logic\Category as CategoryLogic;
use app\common\model\Category as CategoryModel;
use app\Request;

class Category
{
    public function getCategoryList()
    {
        $categoryList = CategoryLogic::getCategoryList();
        return success($categoryList);
    }
}
