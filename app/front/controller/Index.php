<?php
namespace app\front\controller;

use think\facade\View;

class Index
{
    // 首页
    public function index()
    {
        return View::fetch();
    }

    // 关于我们
    public function about()
    {
        return View::fetch();
    }

    // 企业文化
    public function culture()
    {
        return View::fetch();
    }

    // 人才招聘
    public function job()
    {
        return View::fetch();
    }

    // 联系我们
    public function contact()
    {
        return View::fetch();
    }
}
