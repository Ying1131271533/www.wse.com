<?php
namespace app\admin\controller;

use think\facade\View as FacadeView;

class View
{
    // 管理员登录
    public function login()
    {
        return FacadeView::fetch('admin/login');
    }
	
    // 主页框架界面
    public function index()
    {
        return FacadeView::fetch('home/index');
    }

    // 主页 欢迎
    public function welcome()
    {
        return FacadeView::fetch('home/welcome');
    }
	
    // 管理员列表
    public function admin_index()
    {
        return FacadeView::fetch('admin/index');
    }
	
    // 管理员添加
    public function admin_save()
    {
        return FacadeView::fetch('admin/save');
    }
}






















