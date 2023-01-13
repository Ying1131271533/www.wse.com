<?php
namespace app\api\logic;

use app\common\lib\exception\Fail;
use app\common\lib\exception\Miss;
use app\common\model\Platform as PlatformModel;

class Platform
{
    public static function getPlatformList(int $page, int $limit)
    {
        $platformList = PlatformModel::getPageList(
            $page,
            $limit,
            ['status' => 1],
            ['sort', 'view', 'status', 'update_time', 'create_time'],
            ['sort' => 'asc', 'id' => 'asc']
        );
        return $platformList;
    }

    public static function getBasicInfoById(int $id)
    {
        $cache_time = cache_time();
        $platform = PlatformModel::with(['desc' => function($query) {
            $query->field('content, platform_id');
        }])
            ->where('status', 1)
            ->withCache('desc', 'platform:' . $id.':desc', $cache_time)
            ->cache('platform:' . $id.':info', $cache_time)
            ->field('id, title, image, view')
            // ->withoutField('url, sort, status, update_time, create_time, delete_time')
            ->find($id);
        if (empty($platform)) throw new Miss();
        // 浏览量加一
        $platform->inc('view')->update();
        return $platform;
    }
}
