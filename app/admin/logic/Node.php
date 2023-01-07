<?php
namespace app\admin\logic;

use app\common\lib\exception\Fail;
use app\common\lib\exception\Miss;
use app\common\model\Node as NodeModel;
use Exception;

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
        $nodeList = NodeModel::field('id, name, title, parent_id')
        ->order('sort', 'asc')
        ->select();
        if(empty($nodeList)) throw new Miss();
        return $nodeList;
    }

    public static function deleteNode($id)
    {
        // 找到数据
        $node = NodeModel::with('roles')->find($id);
        if(empty($node)) throw new Miss();

        // 是否存在子级数据
        $childrenNode = NodeModel::where('parent_id', $node['id'])->find();
        if(!empty($childrenNode)) throw new Fail('节点存在子级数据，不能删除');

        // 开启事务
        $node->startTrans();
        try {

            // 删除节点中间表数据
            if (!$node['roles']->isEmpty()) {
                $rolesResult = $node->roles()->detach();
                if (!$rolesResult) {
                    throw new Exception('角色中间表数据删除失败');
                }

            }

            $result = $node->delete();
            if (!$result) {
                throw new Exception('节点删除失败');
            }

            $node->commit();
        } catch (Exception $e) {
            $node->rollback();
            throw new Fail($e->getMessage());
        }
    }
}
