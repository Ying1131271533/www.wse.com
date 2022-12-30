<?php
namespace app\admin\logic;

use app\common\lib\exception\Fail;
use app\common\lib\exception\Miss;
use app\common\model\News as NewsModel;
use app\common\model\NewsCate as NewsCateModel;

class NewsCate
{
    public static function saveNewsCate($data)
    {
        $newsCate = new NewsCateModel();
        $id = isset($data['id']) ? $data['id'] : null;
        if($id){
            $newsCate = NewsCateModel::find($id);
            if(empty($newsCate)) throw new Miss();
        }
        
        $result = $newsCate->save($data);
        if(!$result) throw new Fail('保存失败');

        return $newsCate;
    }
    
    public static function getNewsCateList()
    {
        $newsCateList = NewsCateModel::field('id, cate_name, sort')
        ->order('sort')
        ->select()
        ->toArray();
        if(empty($newsCateList)) throw new Miss();
        return $newsCateList;
    }

    public static function deleteNewsCate($id)
    {
        $newsCate = NewsCateModel::find($id);
        if(empty($newsCate)) throw new Miss();

        // 分类是否存在新闻
        $childrenNode = NewsModel::where('News_cate_id', $newsCate['id'])->find();
        if(!empty($childrenNode)) throw new Fail('此分类下存在新闻，不能删除！');

        $result = $newsCate->delete();
        if(!$result) throw new Fail('删除失败');
    }
}
