<?php
namespace app\api\controller;

use app\common\lib\exception\Miss;
use app\common\model\Slides as SlidesModel;
use app\Request;

class Slides
{
    public function getSlidesList(int $category_id)
    {
        $slidesList = SlidesModel::where(['category_id' => $category_id, 'status' => 1])
            ->order(['sort' => 'asc', 'id' => 'asc'])
            ->cache('slides:'.$category_id, cache_time())
            ->field('id, title, image, url')
            ->select();
        if(empty($slidesList)) throw new Miss();
        return success($slidesList->toArray());
    }
}
