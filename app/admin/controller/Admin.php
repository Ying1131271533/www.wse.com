<?php
namespace app\admin\controller;

use app\BaseController;

class Admin extends BaseController
{
    // 用户列表
    public function index()
    {
        return $this->success('威速易后端');
    }
}
