<?php
namespace app\admin\controller;

use app\admin\logic\Auth;
use app\common\lib\facade\Token;

class Home
{
    // 首页
    public function index()
    {
        $admin = Token::getUser();
        $auth = new Auth();
        $showNode = $auth->getShowNode($admin);
        $showNode = get_child($showNode->toArray());
        return success($showNode);
    }

    public function welcome()
    {
        
    }
}
