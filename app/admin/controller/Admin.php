<?php
namespace app\admin\controller;

use app\admin\logic\Admin as AdminLogic;
use app\common\lib\exception\Miss;
use app\common\lib\facade\Token;
use app\common\model\Admin as AdminModel;
use app\Request;
use think\App;

class Admin
{
    protected $logic = null;

    public function __construct()
    {
        // 控制器初始化
        $this->logic = new AdminLogic();
    }

    // 登录
    public function login(Request $request)
    {
        $params = $request->params;
        $token  = $this->logic->login($params);
        return success(['token' => $token]);
    }

    // 退出登录
    public function logout()
    {
        $this->logic->logout();
        return success('退出成功');
    }

    // 是否已登录，验证token
    public function isLogin()
    {
        return success('token验证成功！');
    }

    // 列表
    public function index(Request $request)
    {
        $params          = $request->params;
        $params['page']  = $request->page;
        $params['limit'] = $request->limit;
        $adminList       = $this->logic->getAdminList($params);
        return layui($adminList);
    }

    // 单条
    public function read(int $id)
    {
        $admin = AdminModel::findAdminById($id);
        if (!$admin) throw new Miss();
        return success($admin);
    }

    // 添加
    public function save(Request $request)
    {
        $params = $request->params;
        $this->logic->save($params);
        return success('保存成功');
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
    public function getAdminByToken()
    {
        $user = Token::getUser();
        return success($user);
    }
}
