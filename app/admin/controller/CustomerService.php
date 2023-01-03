<?php
namespace app\admin\controller;

use app\admin\logic\CustomerService as CustomerServiceLogic;
use app\common\lib\exception\Miss;
use app\common\model\CustomerService as CustomerServiceModel;
use app\Request;

class CustomerService
{
    public function save(Request $request)
    {
        $params = $request->params;
        $CustomerService = CustomerServiceLogic::saveCustomerService($params);
        return success($CustomerService);
    }

    public function index()
    {
        $CustomerServiceList = CustomerServiceLogic::getCustomerServiceList();
        return success($CustomerServiceList);
    }

    public function read(int $id)
    {
        $CustomerService = CustomerServiceModel::find($id);
        if(empty($CustomerService)) throw new Miss();
        return success($CustomerService);
    }

    public function update(Request $request)
    {
        $params = $request->params;
        $CustomerService = CustomerServiceLogic::saveCustomerService($params);
        return success($CustomerService);
    }

    public function delete(int $id)
    {
        CustomerServiceLogic::deleteCustomerService($id);
        return success('删除成功');
    }
}
