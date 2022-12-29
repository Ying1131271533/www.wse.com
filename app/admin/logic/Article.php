<?php
namespace app\admin\logic;

use app\common\lib\exception\Fail;
use app\common\lib\exception\Miss;
use app\common\model\Article as ArticleModel;
use Exception;

class Article
{
    public static function saveArticle($data)
    {
        $article = new ArticleModel();
        $id      = isset($data['id']) ? $data['id'] : null;
        if ($id) {
            $article = $article->find($id);
            if (empty($article)) {
                throw new Miss('该文章不存在！');
            }
        }

        // 启动事务
        $article->startTrans();

        try {

            // 保存文章
            $adminResult = $article->save($data);
            if (!$adminResult) throw new Exception('文章保存失败');

            // 保存中间表数据
            $result = $article->desc()->save($data);
            if (!$result) throw new Exception('保存文章内容关联数据失败');

            // 提交事务
            $article->commit();
            return $article;
        } catch (Exception $e) {
            $article->rollback();
            throw new Fail($e->getMessage());
        }
    }

    // 获取文章列表
    public static function getArticleList($data)
    {
        $where                                       = [];
        !empty($data['idReload']) and $where[]       = ['id', '=', $data['idReload']];
        !empty($data['titleReload']) and $where[] = ['title', 'like', "%{$data['titleReload']}%"];
        return ArticleModel::getArticleList($where, $data['page'], $data['limit']);
    }

    public static function deleteById($id)
    {
        // 找到文章
        $article = ArticleModel::with('desc')->find($id);
        if (empty($article)) throw new Miss();

        // 开启事务
        $article->startTrans();
        try {
            // 删除文章
            $result = $article->together(['desc'])->delete();
            if (!$result) throw new Exception('文章删除失败');
            $article->commit();
        } catch (Exception $e) {
            $article->rollback();
            throw new Fail($e->getMessage());
        }
    }

}
