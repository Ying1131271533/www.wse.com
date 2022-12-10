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
    protected $logic = null;

    public function __construct(App $app)
    {
        // 控制器初始化
        parent::__construct($app);
        $this->logic = new AdminLogic();
    }

    // 登录
    public function login()
    {
        $params = $this->request->params;
        $token = $this->logic->login($params);
        return success(['token' => $token]);
    }

    // 退出登录
    public function logout()
    {
        $this->logic->logout();
        return msg('退出成功');
    }

    // 是否已登录，验证token
    public function isLogin()
    {
        return msg('token验证成功！');
    }

    // 列表
    public function index()
    {
        $params = $this->request->params;
        halt($params);
        $adminList = $this->logic->adminList(
            $this->request->page,
            $this->request->limit,
            $params
        );
        return success($adminList);
    }

    // 单条
    public function read(int $id)
    {
        $admin = AdminModel::findAdminById($id);
        if(!$admin) throw new Miss();
        return success($admin);
    }

    // 添加
    public function save()
    {
        $params = $this->request->params;
        $this->logic->save($params);
        return success('保存成功');
    }

    // 更新
    public function update()
    {
        $params = $this->request->params;
        $this->logic->update($params);
        return success('更新成功');
    }

    // 更新密码
    public function password()
    {
        $params = $this->request->params;
        $this->logic->updatePassword($params);
        return success('更新成功');
    }

    // 删除
    public function delete(int $id)
    {
        $this->logic->delete($id);
        return msg('删除成功');
    }

    // 获取用户信息通过token
    public function getAdminByToken()
    {
        $user = Token::getUser();
        return success($user);
    }
}
