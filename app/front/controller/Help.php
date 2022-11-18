<?php
namespace app\front\controller;

use think\facade\View;

class Help
{
    // 帮助中心
    public function index()
    {
        return View::fetch();
    }

    // 详情
    public function detail()
    {
        return View::fetch();
    }
}
