<?php
namespace app\admin\controller;

use app\admin\logic\Node as NodeLogic;
use app\Request;
use LDAP\Result;

class Node
{
    public function save(Request $request)
    {
        $params = $request->params;
        $node = NodeLogic::saveNode($params);
        return success($node);
    }

}
