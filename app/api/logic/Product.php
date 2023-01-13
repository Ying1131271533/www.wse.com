<?php
namespace app\api\logic;

use app\common\lib\exception\Fail;
use app\common\lib\exception\Miss;
use app\common\model\Product as ProductModel;

class Product
{
    public static function getProductList(int $page, int $limit)
    {
        $productList = ProductModel::getPageList(
            $page,
            $limit,
            ['status' => 1],
            ['image', 'view', 'status', 'update_time', 'create_time'],
            ['sort' => 'asc', 'id' => 'asc']
        );
        return $productList;
    }

    public static function getBasicInfoById(int $id)
    {
        $cache_time = cache_time();
        $product = ProductModel::with(['desc' => function($query) {
            $query->field('content, product_id');
        }])
            ->where('status', 1)
            ->withCache('desc', 'product:' . $id.':desc', $cache_time)
            ->cache('product:' . $id.':info', $cache_time)
            ->field('id, title, image, view')
            // ->withoutField('url, sort, status, update_time, create_time, delete_time')
            ->find($id);
        if (empty($product)) throw new Miss();
        // 浏览量加一
        $product->inc('view')->update();
        return $product;
    }
}
