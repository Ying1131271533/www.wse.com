<?php
namespace app\api\logic;

use app\common\lib\exception\Miss;
use app\common\model\Category as CategoryModel;

class Category
{
    public static function getCategoryList()
    {
        $categoryList = CategoryModel::where(['status' => 1, 'show' => 1])
        ->order(['sort' => 'asc', 'id' => 'asc'])
        ->cache('web:category_list', cache_time())
        ->select()
        ->toArray();
        if(empty($categoryList)) throw new Miss();
        $categoryList = get_child($categoryList);
        return $categoryList;
    }
}
