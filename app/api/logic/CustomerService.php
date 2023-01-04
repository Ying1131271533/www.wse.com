<?php
namespace app\api\logic;

use app\common\lib\exception\Fail;
use app\common\lib\exception\Miss;
use app\common\model\CustomerService as CustomerServiceModel;

class CustomerService
{
    public static function getCustomerServiceList()
    {
        $customerServiceList = CustomerServiceModel::withoutField(['real_name'])
        ->where(['status' => 1])
        ->order(['sort' => 'asc', 'id' => 'asc'])
        ->cache('web:customer_service_list', cache_time())
        ->select()
        ->toArray();
        if(empty($customerServiceList)) throw new Miss();
        return $customerServiceList;
    }
}
