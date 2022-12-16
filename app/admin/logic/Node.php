<?php
namespace app\admin\logic;

use app\common\lib\exception\Fail;
use app\common\lib\exception\Miss;
use app\common\model\Node as NodeModel;

class Node
{
    public static function saveNode($data)
    {
        $node = new NodeModel();
        $id = isset($data['id']) ? $data['id'] : null;
        if($id){
            $node = NodeModel::find($id);
            if(empty($node)) throw new Miss();
        }

        $result = $node->save($data);
        if(!$result) throw new Fail('保存失败');

        return $node;
    }
    
    public static function getNodeList()
    {
        $nodeList = NodeModel::field('id, name, title, parent_id')->select()->toArray();
        if(empty($nodeList)) throw new Miss();

        $nodeList = get_child($nodeList);

        return $nodeList;
    }
}
