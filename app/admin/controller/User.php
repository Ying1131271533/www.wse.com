<?php
namespace app\admin\controller;

use app\admin\logic\User as UserLogic;
use app\common\lib\exception\Miss;
use app\common\lib\facade\Token;
use app\common\model\User as UserModel;
use app\Request;

class User
{
    protected $logic = null;

    public function __construct()
    {
        $this->logic = new UserLogic();
    }

    // 列表
    public function index(Request $request)
    {
        $params          = $request->params;
        $params['page']  = $request->page;
        $params['limit'] = $request->limit;
        $userList       = $this->logic->getUserList($params);
        return layui($userList);
    }

    // 单条
    public function read(int $id)
    {
        $user = UserModel::findUserById($id);
        if (!$user) throw new Miss();
        return success($user);
    }

    // 更新
    public function update(Request $request)
    {
        $params = $request->params;
        $this->logic->update($params);
        return success('更新成功');
    }

    // 更新密码
    public function password(Request $request)
    {
        $params = $request->params;
        $this->logic->updatePassword($params);
        return success('更新成功');
    }

    // 删除
    public function delete(int $id)
    {
        $this->logic->delete($id);
        return success('删除成功');
    }

    // 获取用户信息通过token
    public function getUserByToken()
    {
        $user = Token::getUser();
        return success($user);
    }
}
