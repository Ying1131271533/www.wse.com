<?php
namespace app\admin\logic;

use app\common\lib\exception\Fail;
use app\common\lib\exception\Miss;
use app\common\model\Role as RoleModel;

class Role
{
    public static function saveRole($data)
    {
        $role = new RoleModel();
        $id = isset($data['id']) ? $data['id'] : null;
        if($id){
            $role = $role->find($id);
            if(empty($role)){
                throw new Miss('该角色不存在！');
            }
        }

        $result = $role->save($data);
        if (empty($result)) {
            throw new Fail('保存失败');
        }
        return $role;
    }

    public static function deleteById($id)
    {
        $role = RoleModel::find($id);
        if(empty($role)) throw new Miss();

        $result = $role->delete();
        if(empty($result)) throw new Fail('删除失败');
    }
}
