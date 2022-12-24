<?php
namespace app\admin\logic;

use app\common\lib\exception\Fail;
use app\common\lib\exception\Miss;
use app\common\model\Role as RoleModel;
use Exception;

class Role
{
    public static function saveRole($data)
    {
        $role = new RoleModel();
        $id   = isset($data['id']) ? $data['id'] : null;
        if ($id) {
            $role = $role->find($id);
            if (empty($role)) {
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
        $role = RoleModel::with('admins')->find($id);
        if (empty($role)) {
            throw new Miss();
        }

        // 开启事务
        $role->startTrans();
        try {

            // 删除管理员中间表数据
            if (!$role['admins']->isEmpty()) {
                $adminsResult = $role->admins()->detach();
                if (!$adminsResult) {
                    throw new Exception('中间表数据删除失败');
                }
            }

            // 删除节点中间表数据
            if (!$role['nodes']->isEmpty()) {
                $nodesResult = $role->nodes()->detach();
                if (!$nodesResult) {
                    throw new Exception('中间表数据删除失败');
                }

            }

            $result = $role->delete();
            if (!$result) {
                throw new Exception('角色删除失败');
            }

            $role->commit();
        } catch (Exception $e) {
            $role->rollback();
            throw new Fail($e->getMessage());
        }
    }

    public static function saveAuth($data)
    {
        $role = RoleModel::with('nodes')->find($data['id']);
        if(empty($role)) throw new Miss();
        
        // 开启事务
        $role->startTrans();
        try {

            // 删除旧的节点中间表数据
            if (!$role['nodes']->isEmpty()) {
                $nodesResult = $role->nodes()->detach();
                if (!$nodesResult) throw new Exception('原来的节点中间表数据删除失败');
            }

            // 如果有节点权限，则保存
            if(!empty($data['checkData'])){
                $ids = get_key_cloumn('id', $data['checkData']);
                $saveResult = $role->nodes()->saveAll($ids);
                if (!$saveResult) throw new Exception('节点保存失败');
            }

            $role->commit();
        } catch (Exception $e) {
            $role->rollback();
            throw new Fail($e->getMessage());
        }

    }
}
