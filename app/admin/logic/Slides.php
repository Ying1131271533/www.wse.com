<?php
namespace app\admin\logic;

use app\common\lib\exception\Fail;
use app\common\lib\exception\Miss;
use app\common\model\Slides as SlidesModel;
use Exception;

class Slides
{
    public static function saveSlides($data)
    {
        $slides = new SlidesModel();
        $id      = isset($data['id']) ? $data['id'] : null;
        if ($id) {
            $slides = $slides->find($id);
            if (empty($slides)) {
                throw new Miss('该轮播图不存在！');
            }
        }

        // 保存轮播图
        $slidesResult = $slides->save($data);
        if (!$slidesResult) throw new Exception('轮播图保存失败');
    }

    // 获取轮播图列表
    public static function getSlidesList($data)
    {
        $where                                       = [];
        !empty($data['idReload']) and $where[]       = ['id', '=', $data['idReload']];
        !empty($data['titleReload']) and $where[] = ['title', 'like', "%{$data['titleReload']}%"];
        return SlidesModel::getSlidesList($where, $data['page'], $data['limit']);
    }

    public static function deleteById($id)
    {
        // 找到轮播图
        $slides = SlidesModel::find($id);
        if (empty($slides)) throw new Miss();

        // 删除轮播图
        $result = $slides->delete();
        if (!$result) throw new Exception('轮播图删除失败');
    }

}
