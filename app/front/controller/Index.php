<?php
namespace app\front\controller;

class Index extends Base
{
    public function index()
    {
        return 'front/Index/index';
    }

    public function hello($name = 'ThinkPHP6')
    {
        return 'hello,' . $name;
    }
}
