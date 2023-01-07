<?php
namespace app\admin\logic;

use app\common\lib\exception\Fail;
use app\common\lib\exception\Miss;
use app\common\logic\lib\Redis;
use app\common\model\CustomerService as CustomerServiceModel;
use Exception;

class CustomerService
{
    public static function saveCustomerService($data)
    {
        $customerService = new CustomerServiceModel();
        $id              = isset($data['id']) ? $data['id'] : null;
        if ($id) {
            $customerService = CustomerServiceModel::find($id);
            if (empty($customerService)) {
                throw new Miss();
            }

        }

        // redis实例化
        $redis = new Redis();

        // 开启事务
        $customerService->startTrans();
        try {

            // redis开启事务
            $redis->multi();

            // 保存数据
            $result = $customerService->save($data);
            if (!$result) {
                throw new Exception('保存失败');
            }

            // 删除api那边的缓存
            $redis->drdelete('api:customer_service_list');

            // 事务提交
            $customerService->commit();
            $redis->exec();

            // 返回数据
            return $customerService;
        } catch (Exception $e) {
            // 事务回滚
            $customerService->rollback();
            $redis->discard();
            throw new Fail($e->getMessage());
        }
    }

    public static function getCustomerServiceList()
    {
        $customerServiceList = CustomerServiceModel::order(['sort' => 'asc', 'id' => 'asc'])->select()->toArray();
        if (empty($customerServiceList)) {
            throw new Miss();
        }

        return $customerServiceList;
    }

    public static function deleteCustomerService($id)
    {
        $customerService = CustomerServiceModel::find($id);
        if (empty($customerService)) {
            throw new Miss();
        }

        $result = $customerService->delete();
        if (!$result) {
            throw new Fail('删除失败');
        }
        
        // redis实例化
        $redis = new Redis();
        // 删除api那边的缓存
        $redis->drdelete('api:customer_service_list');
    }
}
