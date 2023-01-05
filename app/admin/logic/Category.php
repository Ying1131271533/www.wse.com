<?php
namespace app\admin\logic;

use app\common\lib\exception\Fail;
use app\common\lib\exception\Miss;
use app\common\lib\exception\Success;
use app\common\logic\lib\Redis;
use app\common\model\Category as CategoryModel;
use Exception;

class Category
{
    public static function saveCategory($data)
    {
        $category = new CategoryModel();
        $id       = isset($data['id']) ? $data['id'] : null;
        if ($id) {
            $category = CategoryModel::find($id);
            if (empty($category)) throw new Miss();
        }

        $redis = new Redis();

        // 开启事务
        $category->startTrans();
        try {

            // redis开启事务
            $redis->multi();
            
            $result = $category->save($data);
            if (!$result) {
                throw new Exception('保存失败');
            }

            // 删除api那边的缓存
            $redis->drdelete('api:category_list');

            $category->commit();
            $redis->exec();
            return $category;
        } catch (Exception $e) {
            $category->rollback();
            $redis->discard();
            throw new Fail($e->getMessage());
        }
    }

    public static function getCategoryList()
    {
        $categoryList = CategoryModel::field('id, title, parent_id')
            ->order('sort')
            ->select()
            ->toArray();
        if (empty($categoryList)) {
            throw new Miss();
        }

        $categoryList = get_child($categoryList);
        return $categoryList;
    }

    public static function deleteCategory($id)
    {
        $category = CategoryModel::with('slides')->find($id);
        if (empty($category)) throw new Miss();
        
        // 是否存在轮播图
        if (!$category['slides']->isEmpty()) {
            throw new Fail('分类下存在轮播图');
        }

        // 是否存在子级数据
        $children = CategoryModel::where('parent_id', $category['id'])->find();
        if (!empty($children)) {
            throw new Fail('存在子级数据，不能删除');
        }

        $redis = new Redis();

        // 开启事务
        $category->startTrans();
        try {

            // redis开启事务
            $redis->multi();

            $result = $category->delete();
            if (!$result) {
                throw new Fail('删除失败');
            }

            // 删除图片，删个毛线 软删除就别删除图片了S
            // del_img($category['image']);

            // 删除api那边的缓存
            $redis->drdelete('api:category_list');

            $category->commit();
            $redis->exec();
        } catch (Exception $e) {
            $category->rollback();
            $redis->discard();
            throw new Fail($e->getMessage());
        }
    }
}
