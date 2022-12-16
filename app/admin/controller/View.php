<?php
namespace app\admin\controller;

use think\facade\View as FacadeView;

class View
{
	/************************ 框架 ************************/
	
    // 主页框架界面
    public function index()
    {
        return FacadeView::fetch('home/index');
    }

    // 欢迎
    public function welcome()
    {
        return FacadeView::fetch('home/welcome');
    }
	
	/************************ 管理员 ************************/
	
    // 登录
    public function login()
    {
        return FacadeView::fetch('admin/login');
    }
	
    // 列表
    public function adminIndex()
    {
        return FacadeView::fetch('admin/index');
    }
	
    // 添加
    public function adminSave()
    {
        return FacadeView::fetch('admin/save');
    }
	
    // 更新
    public function adminUpdate()
    {
        return FacadeView::fetch('admin/update');
    }
	
    // 更新密码
    public function adminPassword()
    {
        return FacadeView::fetch('admin/password');
    }
	
	
	/************************ 角色 ************************/
	
    public function roleIndex()
    {
        return FacadeView::fetch('role/index');
    }
    
    public function roleSave()
    {
        return FacadeView::fetch('role/save');
    }

    public function roleUpdate()
    {
        return FacadeView::fetch('role/update');
    }

    public function roleAuth()
    {
        return FacadeView::fetch('role/auth');
    }
	
	
	
	/************************ 节点 ************************/
	
    public function nodeIndex()
    {
        return FacadeView::fetch('node/index');
    }
    
    public function nodeSave()
    {
        return FacadeView::fetch('node/save');
    }

    public function nodeUpdate()
    {
        return FacadeView::fetch('node/update');
    }
	
}






















