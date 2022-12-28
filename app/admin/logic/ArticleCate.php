<?php
namespace app\admin\logic;

use app\common\lib\exception\Fail;
use app\common\lib\exception\Miss;
use app\common\model\Article as ArticleModel;
use app\common\model\ArticleCate as ArticleCateModel;

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
        
        $result = $articleCate->save($data);
        if(!$result) throw new Fail('保存失败');

        return $articleCate;
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

        $result = $articleCate->delete();
        if(!$result) throw new Fail('删除失败');
    }
}
