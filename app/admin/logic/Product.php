<?php
namespace app\admin\logic;

use app\common\lib\exception\Fail;
use app\common\lib\exception\Miss;
use app\common\logic\lib\Redis;
use app\common\model\Product as ProductModel;
use Exception;

class Product
{
    public static function saveProduct($data)
    {
        $product = new ProductModel();
        $id      = isset($data['id']) ? $data['id'] : null;
        if ($id) {
            $product = $product->find($id);
            if (empty($product)) {
                throw new Miss('该产品不存在！');
            }
        }

        // redis实例化
        $redis = new Redis();

        // 启动事务
        $product->startTrans();

        try {

            // redis开启事务
            $redis->multi();

            // 保存数据
            $adminResult = $product->save($data);
            if (!$adminResult) {
                throw new Exception('产品保存失败');
            }

            // 保存中间表数据
            $result = $product->desc()->save($data);
            if (!$result) {
                throw new Exception('保存产品内容的关联数据失败');
            }

            // 删除api那边的缓存
            if ($id) {
                $redis->drclearTag([
                    'product:' . $id . ':info',
                    'product:' . $id . ':desc',
                ]);
            }

            // 提交事务
            $product->commit();
            $redis->exec();

            // 返回数据
            return $product;
        } catch (Exception $e) {
            // 回滚事务
            $product->rollback();
            $redis->discard();
            throw new Fail($e->getMessage());
        }
    }

    // 获取产品列表
    public static function getProductList($data)
    {
        $where                                    = [];
        !empty($data['idReload']) and $where[]    = ['id', '=', $data['idReload']];
        !empty($data['titleReload']) and $where[] = ['title', 'like', "%{$data['titleReload']}%"];
        return ProductModel::getPageList($data['page'], $data['limit'], $where, [], ['id' => 'asc', 'sort' => 'asc']);
    }

    public static function deleteById($id)
    {
        // 找到产品
        $product = ProductModel::with('desc')->find($id);
        if (empty($product)) {
            throw new Miss();
        }

        // redis实例化
        $redis = new Redis();

        // 开启事务
        $product->startTrans();
        try {

            // redis开启事务
            $redis->multi();
            
            // 删除产品
            $result = $product->together(['desc'])->delete();
            if (!$result) {
                throw new Exception('产品删除失败');
            }

            // 删除api那边的缓存
            $redis->drclearTag([
                'product:' . $id . ':info',
                'product:' . $id . ':desc',
            ]);

            $product->commit();
            $redis->exec();
        } catch (Exception $e) {
            // 回滚事务
            $product->rollback();
            $redis->discard();
            throw new Fail($e->getMessage());
        }
    }

}
