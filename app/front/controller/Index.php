<?php
namespace app\front\controller;

class Index extends Base
{
    public function index()
    {
        return 'front/Index/index 威速易前端';
    }

    public function hello($name = 'ThinkPHP6')
    {
        return 'hello,' . $name;
    }
}
