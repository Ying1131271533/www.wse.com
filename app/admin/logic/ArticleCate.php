<?php
namespace app\admin\logic;

use app\common\lib\exception\Fail;
use app\common\lib\exception\Miss;
use app\common\logic\lib\Redis;
use app\common\model\Article as ArticleModel;
use app\common\model\ArticleCate as ArticleCateModel;
use Exception;

class ArticleCate
{
    public static function saveArticleCate($data)
    {
        $articleCate = new ArticleCateModel();
        $id = isset($data['id']) ? $data['id'] : null;
        if($id){
            $articleCate = ArticleCateModel::find($id);
            if(empty($articleCate)) throw new Miss();
        }
        
        $redis = new Redis();
        // 启动事务
        $articleCate->startTrans();

        try {

            // redis开启事务
            $redis->multi();

            // 保存数据
            $result = $articleCate->save($data);
            if(!$result) throw new Fail('保存失败');

            // 删除所有在此分类下的文章关联数据cate
            if($id){
                $articleCateKeys = $redis->keys('article:*:cate');
                $redis->drclearTag($articleCateKeys);
            }

            // 提交事务
            $articleCate->commit();
            $redis->exec();

            // 返回数据
            return $articleCate;
        } catch (Exception $e) {
            // 回滚事务
            $articleCate->rollback();
            $redis->discard();
            throw new Fail($e->getMessage());
        }
    }
    
    public static function getArticleCateList()
    {
        $articleCateList = ArticleCateModel::field('id, cate_name, sort')
        ->order('sort')
        ->select()
        ->toArray();
        if(empty($articleCateList)) throw new Miss();
        return $articleCateList;
    }

    public static function deleteArticleCate($id)
    {
        $articleCate = ArticleCateModel::find($id);
        if(empty($articleCate)) throw new Miss();

        // 分类是否存在文章
        $childrenNode = ArticleModel::where('article_cate_id', $articleCate['id'])->find();
        if(!empty($childrenNode)) throw new Fail('此分类下存在文章，不能删除！');

        $redis = new Redis();
        // 启动事务
        $articleCate->startTrans();
        
        try {

            // redis开启事务
            $redis->multi();

            $result = $articleCate->delete();
            if(!$result) throw new Exception('删除失败');

            // 删除所有在此分类下的文章关联数据cate
            $articleCateKeys = $redis->keys('article:*:cate');
            $redis->drclearTag($articleCateKeys);

            // 提交事务
            $articleCate->commit();
            $redis->exec();
            return $articleCate;
        } catch (Exception $e) {
            // 回滚事务
            $articleCate->rollback();
            $redis->discard();
            throw new Fail($e->getMessage());
        }
    }
}
