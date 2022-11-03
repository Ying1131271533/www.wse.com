<?php
namespace app\front\controller;

use think\facade\View;

class Index
{
    public function index()
    {
        return View::fetch();
    }
}
