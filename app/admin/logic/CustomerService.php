<?php
namespace app\admin\logic;

use app\common\lib\exception\Fail;
use app\common\lib\exception\Miss;
use app\common\model\CustomerService as CustomerServiceModel;

class CustomerService
{
    public static function saveCustomerService($data)
    {
        $customerService = new CustomerServiceModel();
        $id = isset($data['id']) ? $data['id'] : null;
        if($id){
            $customerService = CustomerServiceModel::find($id);
            if(empty($customerService)) throw new Miss();
        }
        
        $result = $customerService->save($data);
        if(!$result) throw new Fail('保存失败');

        return $customerService;
    }
    
    public static function getCustomerServiceList()
    {
        $customerServiceList = CustomerServiceModel::order(['sort' => 'asc', 'id' => 'asc'])->select()->toArray();
        if(empty($customerServiceList)) throw new Miss();
        return $customerServiceList;
    }

    public static function deleteCustomerService($id)
    {
        $customerService = CustomerServiceModel::find($id);
        if(empty($customerService)) throw new Miss();
        $result = $customerService->delete();
        if(!$result) throw new Fail('删除失败');
    }
}
