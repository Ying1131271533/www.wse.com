<?php
namespace app\admin\controller;

class Index extends Base
{
    public function index()
    {
        return 'admin/Index/index';
    }

    public function hello($name = 'ThinkPHP6')
    {
        return 'hello,' . $name;
    }
}
