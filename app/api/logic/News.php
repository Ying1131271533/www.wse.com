<?php
namespace app\api\logic;

use app\common\lib\exception\Fail;
use app\common\lib\exception\Miss;
use app\common\model\News as NewsModel;

class News
{
    public static function getNewsList(int $page, int $limit)
    {
        $newsList = NewsModel::getPageList(
            $page, $limit,
            ['status' => 1],
            [],
            ['sort' => 'desc', 'id' => 'desc']
        );
        return $newsList;
    }

    public static function getBasicInfoById(int $id)
    {
        $cache_time = cache_time();
        $news = NewsModel::with(['desc' => function($query) {
            $query->field('content, news_id');
        }, 'cate' => function($query) {
            $query->field('id, cate_name');
        }])
            ->where('status', 1)
            ->withCache('cate', 'news:' . $id.':cate', $cache_time)
            ->withCache('desc', 'news:' . $id.':desc', $cache_time)
            ->cache('news:' . $id.':info', $cache_time)
            ->field('id, title, author, image, description, view, news_cate_id')
            // ->withoutField('url, sort, status, update_time, create_time, delete_time')
            ->find($id);
        if (empty($news)) throw new Miss();
        // 浏览量加一
        $news->inc('view')->update();
        return $news;
    }
}
