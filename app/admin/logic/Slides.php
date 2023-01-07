<?php
namespace app\admin\logic;

use app\common\lib\exception\Fail;
use app\common\lib\exception\Miss;
use app\common\logic\lib\Redis;
use app\common\model\Slides as SlidesModel;
use Exception;

class Slides
{
    public static function saveSlides($data)
    {
        $slides = new SlidesModel();
        $id     = isset($data['id']) ? $data['id'] : null;
        if ($id) {
            $slides = $slides->find($id);
            if (empty($slides)) {
                throw new Miss('该轮播图不存在！');
            }
        }

        // redis实例化
        $redis = new Redis();

        // 开启事务
        $slides->startTrans();
        try {

            // redis开启事务
            $redis->multi();

            // 保存数据
            $result = $slides->save($data);
            if (!$result) {
                throw new Exception('轮播图保存失败');
            }

            // 删除api那边的缓存
            $redis->drdelete('slides:' . $slides['category_id']);

            // 事务提交
            $slides->commit();
            $redis->exec();

            // 返回数据
            return $slides;
        } catch (Exception $e) {
            // 事务回滚
            $slides->rollback();
            $redis->discard();
            throw new Fail($e->getMessage());
        }
    }

    // 获取轮播图列表
    public static function getSlidesList($data)
    {
        $where                                    = [];
        !empty($data['idReload']) and $where[]    = ['id', '=', $data['idReload']];
        !empty($data['titleReload']) and $where[] = ['title', 'like', "%{$data['titleReload']}%"];
        return SlidesModel::getSlidesList($where, $data['page'], $data['limit']);
    }

    public static function deleteById($id)
    {
        // 找到轮播图
        $slides = SlidesModel::find($id);
        if (empty($slides)) {
            throw new Miss();
        }

        // redis实例化
        $redis = new Redis();

        // 开启事务
        $slides->startTrans();
        try {

            // redis开启事务
            $redis->multi();

            // 删除轮播图
            $result = $slides->delete();
            if (!$result) {
                throw new Exception('轮播图删除失败');
            }

            // 删除api那边的缓存
            $redis->drdelete('slides:' . $slides['category_id']);

            // 事务提交
            $slides->commit();
            $redis->exec();

            // 返回数据
            return $slides;
        } catch (Exception $e) {
            // 事务回滚
            $slides->rollback();
            $redis->discard();
            throw new Fail($e->getMessage());
        }
    }

}
