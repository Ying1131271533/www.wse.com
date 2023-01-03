<?php
namespace app\api\controller;

use app\api\logic\CustomerService as CustomerServiceLogic;
use app\Request;

class CustomerService
{
    public function getCustomerServiceList()
    {
        $CustomerServiceList = CustomerServiceLogic::getCustomerServiceList();
        return success($CustomerServiceList);
    }
}
