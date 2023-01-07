<?php
namespace app\admin\logic;

use app\common\lib\exception\Fail;
use app\common\lib\exception\Miss;
use app\common\logic\lib\Redis;
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

        // redis实例化
        $redis = new Redis();

        // 启动事务
        $article->startTrans();

        try {

            // redis开启事务
            $redis->multi();

            // 保存数据
            $adminResult = $article->save($data);
            if (!$adminResult) {
                throw new Exception('文章保存失败');
            }

            // 保存中间表数据
            $result = $article->desc()->save($data);
            if (!$result) {
                throw new Exception('保存文章内容关联数据失败');
            }

            // 删除api那边的缓存
            if ($id) {
                $redis->drclearTag([
                    'article:' . $id . ':info',
                    'article:' . $id . ':cate',
                    'article:' . $id . ':desc',
                ]);
            }

            // 提交事务
            $article->commit();
            $redis->exec();

            // 返回数据
            return $article;
        } catch (Exception $e) {
            // 回滚事务
            $article->rollback();
            $redis->discard();
            throw new Fail($e->getMessage());
        }
    }

    // 获取文章列表
    public static function getArticleList($data)
    {
        $where                                    = [];
        !empty($data['idReload']) and $where[]    = ['id', '=', $data['idReload']];
        !empty($data['titleReload']) and $where[] = ['title', 'like', "%{$data['titleReload']}%"];
        return ArticleModel::getArticleList($where, $data['page'], $data['limit']);
    }

    public static function deleteById($id)
    {
        // 找到文章
        $article = ArticleModel::with('desc')->find($id);
        if (empty($article)) {
            throw new Miss();
        }

        // redis实例化
        $redis = new Redis();

        // 开启事务
        $article->startTrans();
        try {

            // redis开启事务
            $redis->multi();
            
            // 删除文章
            $result = $article->together(['desc'])->delete();
            if (!$result) {
                throw new Exception('文章删除失败');
            }

            // 删除api那边的缓存
            $redis->drclearTag([
                'article:' . $id . ':info',
                'article:' . $id . ':cate',
                'article:' . $id . ':desc',
            ]);

            $article->commit();
            $redis->exec();
        } catch (Exception $e) {
            // 回滚事务
            $article->rollback();
            $redis->discard();
            throw new Fail($e->getMessage());
        }
    }

}
