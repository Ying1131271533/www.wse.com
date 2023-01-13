<?php
namespace app\admin\controller;

use app\admin\logic\Admin as AdminLogic;
use app\BaseController;
use app\common\lib\exception\Miss;
use app\common\lib\Token;
use app\common\model\Admin as AdminModel;
use think\App;

class Admin extends BaseController
{
    // 添加
    public function register()
    {
        $params = $this->request->params;
        AdminLogic::register($params);
        return success('保存成功');
    }

    // 登录
    public function login()
    {
        $params = $this->request->params;
        $token  = AdminLogic::login($params);
        return success(['token' => $token]);
    }

    // 退出登录
    public function logout()
    {
        AdminLogic::logout();
        return success('退出成功');
    }

    // 是否已登录，验证token
    public function isLogin()
    {
        return success('token验证成功！');
    }

    // 列表
    public function index()
    {
        $params          = $this->request->params;
        $params['page']  = $this->request->page;
        $params['limit'] = $this->request->limit;
        $adminList       = AdminLogic::getAdminList($params);
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
    public function save()
    {
        $params = $this->request->params;
        AdminLogic::save($params);
        return success('保存成功');
    }

    // 更新
    public function update()
    {
        $params = $this->request->params;
        AdminLogic::update($params);
        return success('更新成功');
    }

    // 更新密码
    public function password()
    {
        $params = $this->request->params;
        AdminLogic::updatePassword($params);
        return success('更新成功');
    }

    // 删除
    public function delete(int $id)
    {
        AdminLogic::delete($id);
        return success('删除成功');
    }

    // 获取用户信息通过token
    public function getAdminByToken()
    {
        $user = Token::getUser();
        return success($user);
    }
}
