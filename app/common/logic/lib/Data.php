<?php

namespace app\common\logic\lib;

use app\common\lib\exception\Fail;
use Exception;
use think\facade\Db;

class Data
{
    /**
     * @description:  オラ!オラ!オラ!オラ!⎛⎝≥⏝⏝≤⎛⎝
     * @author: 神织知更
     * @time: 2022/12/06 16:05
     *
     * 修改数据字段的值
     *
     * @param  array    $data   数据
     * @return json             api返回的json数据
     */
    public function changeFieldValue($data)
    {
        // redis实例化
        $redis = new Redis();
        
        // 启动事务
        Db::startTrans();

        try {
            // redis开启事务
            $redis->multi();

            // 更新数据
            $result = Db::table($data['db'])
            ->where('id', $data['id'])
            ->cache(true)
            ->update([$data['field'] => $data['value']]);
            if (!$result) {
                throw new Exception('更新失败');
            }

            // 获取数据所有的缓存key
            $cacheKeys = $redis->keys($data['db'] . ':' . $data['id'] . '*');
            // 删除缓存
            if (!empty($cacheKeys)) {
                $redis->drclearTag($cacheKeys);
            }

            // 提交事务
            Db::commit();
            $redis->exec();

            // 返回数据
            return [
                'id'    => $data['id'],
                'value' => $data['value'],
            ];
        } catch (Exception $e) {
            // 回滚事务
            Db::rollback();
            $redis->discard();
            throw new Fail($e->getMessage());
        }
    }

    // 暂时不用这里，而是使用redis的keys正则匹配来删除
    public function deleteRedisCache($redis, $data)
    {
        switch ($data['db']) {
            // 文章
            case 'article':
                $redis->drclearTag([
                    'article:' . $data['id'] . ':info',
                    'article:' . $data['id'] . ':cate',
                    'article:' . $data['id'] . ':desc',
                ]);
                break;

            default:

                break;
        }
    }
}
