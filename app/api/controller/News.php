<?php
namespace app\api\controller;

use app\api\logic\News as NewsLogic;
use app\Request;

class News
{
    public function getNewsList(Request $request)
    {
        $page  = $request->page;
        $limit = $request->limit;
        $newsList = NewsLogic::getNewsList($page, $limit);
        return success($newsList);
    }

    public function getBasicInfo(int $id)
    {
        $news = NewsLogic::getBasicInfoById($id);
        return success($news);
    }
}
