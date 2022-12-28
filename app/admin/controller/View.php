<?php
namespace app\admin\controller;

use think\facade\View as FacadeView;
use app\admin\logic\Auth;
use app\common\lib\Token;

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
	
	/************************ 分类 ************************/
	
    public function categoryIndex()
    {
        return FacadeView::fetch('category/index');
    }
    
    public function categorySave()
    {
        return FacadeView::fetch('category/save');
    }

    public function categoryUpdate()
    {
        return FacadeView::fetch('category/update');
    }

	/************************ 文章分类 ************************/
	
    public function articleCateIndex()
    {
        return FacadeView::fetch('article_cate/index');
    }
    
    public function articleCateSave()
    {
        return FacadeView::fetch('article_cate/save');
    }

    public function articleCateUpdate()
    {
        return FacadeView::fetch('article_cate/update');
    }

	/************************ 文章管理 ************************/
	
    public function articleIndex()
    {
        return FacadeView::fetch('article/index');
    }
    
    public function articleSave()
    {
        return FacadeView::fetch('article/save');
    }

    public function articleUpdate()
    {
        return FacadeView::fetch('article/update');
    }
	
}






















