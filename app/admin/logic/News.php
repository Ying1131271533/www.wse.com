<?php
namespace app\admin\logic;

use app\common\lib\exception\Fail;
use app\common\lib\exception\Miss;
use app\common\model\News as NewsModel;
use Exception;

class News
{
    public static function saveNews($data)
    {
        $news = new NewsModel();
        $id      = isset($data['id']) ? $data['id'] : null;
        if ($id) {
            $news = $news->find($id);
            if (empty($news)) {
                throw new Miss('该新闻不存在！');
            }
        }

        // 启动事务
        $news->startTrans();

        try {

            // 保存新闻
            $adminResult = $news->save($data);
            if (!$adminResult) throw new Exception('新闻保存失败');

            // 保存中间表数据
            $result = $news->desc()->save($data);
            if (!$result) throw new Exception('保存新闻内容关联数据失败');

            // 提交事务
            $news->commit();
            return $news;
        } catch (Exception $e) {
            $news->rollback();
            throw new Fail($e->getMessage());
        }
    }

    // 获取新闻列表
    public static function getNewsList($data)
    {
        $where                                       = [];
        !empty($data['idReload']) and $where[]       = ['id', '=', $data['idReload']];
        !empty($data['titleReload']) and $where[] = ['title', 'like', "%{$data['titleReload']}%"];
        return NewsModel::getNewsList($where, $data['page'], $data['limit']);
    }

    public static function deleteById($id)
    {
        // 找到新闻
        $news = NewsModel::with('desc')->find($id);
        if (empty($news)) throw new Miss();

        // 开启事务
        $news->startTrans();
        try {
            // 删除新闻
            $result = $news->together(['desc'])->delete();
            if (!$result) throw new Exception('新闻删除失败');
            $news->commit();
        } catch (Exception $e) {
            $news->rollback();
            throw new Fail($e->getMessage());
        }
    }

}
