<?php
namespace app\admin\controller;

use app\admin\logic\Role as RoleLogic;
use app\common\lib\exception\Fail;
use app\common\lib\exception\Miss;
use app\common\model\Role as RoleModel;
use app\Request;

class Role
{
    public function save(Request $request)
    {
        $params = $request->params;
        $role = RoleLogic::saveRole($params);
        return success($role);
    }
    
    public function read(int $id)
    {
        $role = RoleModel::with('nodes')->find($id);
        if(empty($role)) throw new Miss('找不到该角色！');
        return success($role);
    }

    public function index()
    {
        $roleList = RoleModel::select();
        if(empty($roleList)) throw new Miss();
        return success($roleList);
    }

    public function update(Request $request)
    {
        $params = $request->params;
        $role = RoleLogic::saveRole($params);
        return success($role);
    }

    public function delete(int $id)
    {
        RoleLogic::deleteById($id);
        return success('删除成功');
    }

    public function auth(Request $request)
    {
        $params = $request->params;
        $role = RoleLogic::saveAuth($params);
        return success($role);
    }

    // 获取选中的节点ids
    public function checkedNode(int $id)
    {
        $role = RoleModel::with('nodes')->find($id);
        if(empty($role)) throw new Miss('找不到该角色！');
        $checkedNode = RoleLogic::getCheckedNode($role['nodes']->toArray());
        return success($checkedNode);
    }
}
