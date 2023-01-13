<?php
namespace app\admin\logic;

use app\common\lib\exception\Fail;
use app\common\lib\exception\Miss;
use app\common\logic\lib\Redis;
use app\common\model\Platform as PlatformModel;
use Exception;

class Platform
{
    public static function savePlatform($data)
    {
        $platform = new PlatformModel();
        $id      = isset($data['id']) ? $data['id'] : null;
        if ($id) {
            $platform = $platform->find($id);
            if (empty($platform)) {
                throw new Miss('该平台不存在！');
            }
        }

        // redis实例化
        $redis = new Redis();

        // 启动事务
        $platform->startTrans();

        try {

            // redis开启事务
            $redis->multi();

            // 保存数据
            $adminResult = $platform->save($data);
            if (!$adminResult) {
                throw new Exception('平台保存失败');
            }

            // 保存中间表数据
            $result = $platform->desc()->save($data);
            if (!$result) {
                throw new Exception('保存平台的内容关联数据失败');
            }

            // 删除api那边的缓存
            if ($id) {
                $redis->drclearTag([
                    'platform:' . $id . ':info',
                    'platform:' . $id . ':desc',
                ]);
            }

            // 提交事务
            $platform->commit();
            $redis->exec();

            // 返回数据
            return $platform;
        } catch (Exception $e) {
            // 回滚事务
            $platform->rollback();
            $redis->discard();
            throw new Fail($e->getMessage());
        }
    }

    // 获取平台列表
    public static function getPlatformList($data)
    {
        $where                                    = [];
        !empty($data['idReload']) and $where[]    = ['id', '=', $data['idReload']];
        !empty($data['titleReload']) and $where[] = ['title', 'like', "%{$data['titleReload']}%"];
        return PlatformModel::getPageList(
            $data['page'],
            $data['limit'],
            $where,
            [],
            ['id' => 'asc', 'sort' => 'asc']
        );
    }

    public static function deleteById($id)
    {
        // 找到平台
        $platform = PlatformModel::with('desc')->find($id);
        if (empty($platform)) {
            throw new Miss();
        }

        // redis实例化
        $redis = new Redis();

        // 开启事务
        $platform->startTrans();
        try {

            // redis开启事务
            $redis->multi();
            
            // 删除平台
            $result = $platform->together(['desc'])->delete();
            if (!$result) {
                throw new Exception('平台删除失败');
            }

            // 删除api那边的缓存
            $redis->drclearTag([
                'platform:' . $id . ':info',
                'platform:' . $id . ':desc',
            ]);

            $platform->commit();
            $redis->exec();
        } catch (Exception $e) {
            // 回滚事务
            $platform->rollback();
            $redis->discard();
            throw new Fail($e->getMessage());
        }
    }

}
