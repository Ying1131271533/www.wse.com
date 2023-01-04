<?php
namespace app\api\controller;

use app\common\lib\exception\Miss;
use app\common\model\News as NewsModel;
use app\Request;

class News
{
    public function getNewsList(Request $request)
    {
        $params['page']  = $request->page;
        $params['limit'] = $request->limit;
        $NewsList = NewsModel::getPageList(
            $params['page'], $params['limit'],
            ['status' => 1],
            [],
            ['sort' => 'desc', 'id' => 'desc']
        );
        return success($NewsList);
    }

    public function getBasicInfo(int $id)
    {
        $news = NewsModel::with(['desc', 'cate'])
            ->withCache('cate', 'news:' . $id.':cate', cache_time())
            ->withCache('desc', 'news:' . $id.':desc', cache_time())
            ->cache('news:' . $id.':info', cache_time())
            ->find($id);
        if (empty($news)) throw new Miss();
        return success($news);
    }
}
