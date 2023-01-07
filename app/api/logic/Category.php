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
            ->cache('api:category_list', cache_time())
            ->withoutField('show, sort, status, update_time')
            ->select();
        if (empty($categoryList)) {
            throw new Miss();
        }

        return $categoryList;
    }
}
