<?php
namespace app\admin\logic;

use app\common\lib\exception\Fail;
use app\common\lib\exception\Miss;
use app\common\model\Category as CategoryModel;

class Category
{
    public static function saveCategory($data)
    {
        $category = new CategoryModel();
        $id = isset($data['id']) ? $data['id'] : null;
        if($id){
            $category = CategoryModel::find($id);
            if(empty($category)) throw new Miss();
        }
        
        $result = $category->save($data);
        if(!$result) throw new Fail('保存失败');

        return $category;
    }
    
    public static function getCategoryList()
    {
        $categoryList = CategoryModel::field('id, title, parent_id')
        ->order('sort')
        ->select()
        ->toArray();
        if(empty($categoryList)) throw new Miss();
        $categoryList = get_child($categoryList);
        return $categoryList;
    }

    public static function deleteCategory($id)
    {
        $category = CategoryModel::find($id);
        if(empty($category)) throw new Miss();

        // 是否存在子级数据
        $childrenNode = CategoryModel::where('parent_id', $category['id'])->find();
        if(!empty($childrenNode)) throw new Fail('存在子级数据，不能删除');

        $result = $category->delete();
        if(!$result) throw new Fail('删除失败');
        // 删除图片，删个毛线 软删除就别删除了
        // del_img($category['image']);
    }
}
