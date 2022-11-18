<?php
namespace app\front\controller;

use think\facade\View;

class Index
{
    public function index()
    {
        return View::fetch();
    }

    public function about()
    {
        return View::fetch();
    }

    public function culture()
    {
        return View::fetch();
    }

    public function job()
    {
        return View::fetch();
    }

    public function contact()
    {
        return View::fetch();
    }
}
