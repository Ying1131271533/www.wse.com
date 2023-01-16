<?php
namespace app\api\controller;

use app\api\logic\User as UserLogic;
use app\common\lib\ApiToken;
use app\common\model\User as UserModel;
use app\Request;

class User
{
    // 注册
    public function register(Request $request)
    {
        $params = $request->params;
        $token = UserLogic::register($params);
        return success(['token' => $token]);
    }

    // 登录
    public function login(Request $request)
    {
        $params = $request->params;
        $token  = UserLogic::login($params);
        return success(['token' => $token]);
    }

    // 退出登录
    public function logout()
    {
        UserLogic::logout();
        return success('退出成功');
    }

    // 是否已登录，验证token
    public function isLogin()
    {
        return success('token验证成功！');
    }

    // 用户中心
    public function index()
    {

    }

    // 使用token获取用户信息
    public function getUserByToken()
    {
        $user = ApiToken::getUser();
        return success($user);
    }

    // 使用id获取用户信息
    public function getUserById(int $id)
    {
        $user = UserModel::findUserById($id);
        return success($user);
    }

    // 获取邀请码
    public function getInvitationCode()
    {
        $invitation_code = UserLogic::createInvitationCode();
        return success(['invitation_code' => $invitation_code]);
    }
}
