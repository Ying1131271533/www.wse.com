<?php
namespace app\front\controller;

use think\facade\View;

class User
{
    public function index()
    {
        return View::fetch();
    }

    public function userRegister()
    {
        return View::fetch();
    }

    public function userLogin()
    {
        return View::fetch();
    }
}
