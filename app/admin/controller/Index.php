<?php
namespace app\admin\controller;

use app\BaseController;

class Index extends BaseController
{
    // 首页
    public function index()
    {
        return $this->success('威速易后端');
    }
}
