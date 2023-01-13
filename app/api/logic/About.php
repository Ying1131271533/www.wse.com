<?php
namespace app\api\logic;

use app\common\lib\exception\Fail;
use app\common\lib\exception\Miss;
use app\common\model\About as AboutModel;

class About
{
    public static function getBasicInfoById(int $id)
    {
        $cache_time = cache_time();
        $about      = AboutModel::with(['desc' => function ($query) {
            $query->field('content, about_id');
        }, 'cate' => function ($query) {
            $query->field('id, cate_name');
        }])
            ->where('status', 1)
            ->field('id, title, author, image, description, view, about_cate_id')
            ->find($id);
        if (empty($about)) throw new Miss();

        // 浏览量加一
        $about->inc('view')->update();
        return $about;
    }
}
