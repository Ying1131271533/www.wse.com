<?php
namespace app\admin\controller;

use app\admin\logic\Product as ProductLogic;
use app\common\lib\exception\Fail;
use app\common\lib\exception\Miss;
use app\common\model\Product as ProductModel;
use app\Request;

class Product
{
    public function save(Request $request)
    {
        $params = $request->params;
        $product = ProductLogic::saveProduct($params);
        return success($product);
    }
    
    public function read(int $id)
    {
        $product = ProductModel::with(['desc'])->find($id);
        if(empty($product)) throw new Miss();
        return success($product);
    }

    // 列表
    public function index(Request $request)
    {
        $params          = $request->params;
        $params['page']  = $request->page;
        $params['limit'] = $request->limit;
        $adminList       = ProductLogic::getProductList($params);
        return layui($adminList);
    }

    public function update(Request $request)
    {
        $params = $request->params;
        $product = ProductLogic::saveProduct($params);
        return success($product);
    }

    public function delete(int $id)
    {
        ProductLogic::deleteById($id);
        return success('删除成功');
    }
}
