<?php
namespace app\admin\logic;

use app\common\lib\exception\Fail;
use app\common\lib\exception\Miss;
use app\common\model\About as AboutModel;
use app\common\model\AboutCate as AboutCateModel;

class AboutCate
{
    public static function saveAboutCate($data)
    {
        $aboutCate = new AboutCateModel();
        $id = isset($data['id']) ? $data['id'] : null;
        if($id){
            $aboutCate = AboutCateModel::find($id);
            if(empty($aboutCate)) throw new Miss();
        }
        
        $result = $aboutCate->save($data);
        if(!$result) throw new Fail('保存失败');

        return $aboutCate;
    }
    
    public static function getAboutCateList()
    {
        $aboutCateList = AboutCateModel::field('id, cate_name, sort')
        ->order('sort')
        ->select()
        ->toArray();
        if(empty($aboutCateList)) throw new Miss();
        return $aboutCateList;
    }

    public static function deleteAboutCate($id)
    {
        $aboutCate = AboutCateModel::find($id);
        if(empty($aboutCate)) throw new Miss();

        // 分类是否存在文章
        $childrenNode = AboutModel::where('About_cate_id', $aboutCate['id'])->find();
        if(!empty($childrenNode)) throw new Fail('此分类下存在文章，不能删除！');

        $result = $aboutCate->delete();
        if(!$result) throw new Fail('删除失败');
    }
}
