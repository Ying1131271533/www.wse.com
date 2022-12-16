<?php
namespace app\admin\controller;

use app\admin\logic\Node as NodeLogic;
use app\common\lib\exception\Miss;
use app\common\model\Node as NodeModel;
use app\Request;

class Node
{
    public function save(Request $request)
    {
        $params = $request->params;
        $node = NodeLogic::saveNode($params);
        return success($node);
    }

    public function read(int $id)
    {
        $node = NodeModel::find($id);
        if(empty($node)) throw new Miss();
        return success($node);
    }

    public function index()
    {
        $nodeList = NodeLogic::getNodeList();
        return success($nodeList);
    }

    public function delete(int $id)
    {
        
    }
}
