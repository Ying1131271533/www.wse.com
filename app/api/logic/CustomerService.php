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
        ->order(['sort' => 'asc', 'id' => 'asc'])
        ->select()
        ->toArray();
        if(empty($customerServiceList)) throw new Miss();
        return $customerServiceList;
    }
}
