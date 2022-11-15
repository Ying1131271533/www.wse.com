<?php
namespace app\front\controller;

use think\facade\View;

class User
{
    public function index()
    {
        return View::fetch();
    }

    public function register()
    {
        return View::fetch();
    }

    public function login()
    {
        return View::fetch();
    }
}
