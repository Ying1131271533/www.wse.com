<?php
namespace app\admin\controller;

use app\BaseController;

class User extends BaseController
{
    // 用户列表
    public function index()
    {
        return $this->success('威速易后端');
    }
}
