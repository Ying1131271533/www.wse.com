<?php
namespace app\admin\controller;

use app\admin\logic\News as NewsLogic;
use app\common\lib\exception\Fail;
use app\common\lib\exception\Miss;
use app\common\model\News as NewsModel;
use app\Request;

class News
{
    public function save(Request $request)
    {
        $params = $request->params;
        $news = NewsLogic::saveNews($params);
        return success($news);
    }
    
    public function read(int $id)
    {
        $news = NewsModel::with(['cate', 'desc'])->find($id);
        if(empty($news)) throw new Miss();
        return success($news);
    }

    // 列表
    public function index(Request $request)
    {
        $params          = $request->params;
        $params['page']  = $request->page;
        $params['limit'] = $request->limit;
        $adminList       = NewsLogic::getNewsList($params);
        return layui($adminList);
    }

    public function update(Request $request)
    {
        $params = $request->params;
        $news = NewsLogic::saveNews($params);
        return success($news);
    }

    public function delete(int $id)
    {
        NewsLogic::deleteById($id);
        return success('删除成功');
    }
}
