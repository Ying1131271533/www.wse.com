<?php
namespace app\admin\controller;

use app\admin\logic\Category as CategoryLogic;
use app\common\lib\exception\Miss;
use app\common\model\Category as CategoryModel;
use app\Request;

class Category
{
    public function save(Request $request)
    {
        $params = $request->params;
        $category = CategoryLogic::saveCategory($params);
        return success($category);
    }

    public function index()
    {
        $categoryList = CategoryLogic::getCategoryList();
        return success($categoryList);
    }

    public function read(int $id)
    {
        $category = CategoryModel::find($id);
        if(empty($category)) throw new Miss();
        return success($category);
    }

    public function update(Request $request)
    {
        $params = $request->params;
        $category = CategoryLogic::saveCategory($params);
        return success($category);
    }

    public function delete(int $id)
    {
        CategoryLogic::deleteCategory($id);
        return success('删除成功');
    }
}
