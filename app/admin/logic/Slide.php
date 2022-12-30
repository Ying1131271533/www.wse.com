<?php
namespace app\admin\logic;

use app\common\lib\exception\Fail;
use app\common\lib\exception\Miss;
use app\common\model\Slide as SlideModel;
use Exception;

class Slide
{
    public static function saveSlide($data)
    {
        $slide = new SlideModel();
        $id      = isset($data['id']) ? $data['id'] : null;
        if ($id) {
            $slide = $slide->find($id);
            if (empty($slide)) {
                throw new Miss('该轮播图不存在！');
            }
        }

        // 启动事务
        $slide->startTrans();

        try {

            // 删除关联表数据
            if (!$id) {
                $imgsResult = $slide->imgs()->detach();
                if (!$imgsResult) {
                    throw new Exception('轮播图关联表数据删除失败');
                }
            }

            // 保存轮播图
            $slideResult = $slide->save($data);
            if (!$slideResult) throw new Exception('轮播图保存失败');

            // 组装轮播图路径数据
            $imgs = [];
            foreach($data['imgs'] as $value){
                $imgs['path'] = $value;
            }

            // 保存关联表数据
            $result = $slide->imgs()->saveAll($imgs);
            if (!$result) throw new Exception('保存轮播图关联数据失败');

            // 提交事务
            $slide->commit();
            return $slide;
        } catch (Exception $e) {
            $slide->rollback();
            throw new Fail($e->getMessage());
        }
    }

    // 获取轮播图列表
    public static function getSlideList($data)
    {
        $where                                       = [];
        !empty($data['idReload']) and $where[]       = ['id', '=', $data['idReload']];
        !empty($data['titleReload']) and $where[] = ['title', 'like', "%{$data['titleReload']}%"];
        return SlideModel::getSlideList($where, $data['page'], $data['limit']);
    }

    public static function deleteById($id)
    {
        // 找到轮播图
        $slide = SlideModel::with('imgs')->find($id);
        if (empty($slide)) throw new Miss();

        // 开启事务
        $slide->startTrans();
        try {
            // 删除轮播图
            $result = $slide->together(['imgs'])->delete();
            if (!$result) throw new Exception('轮播图删除失败');
            $slide->commit();
        } catch (Exception $e) {
            $slide->rollback();
            throw new Fail($e->getMessage());
        }
    }

}
