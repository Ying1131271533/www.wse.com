<?php
namespace app\admin\controller;

use app\admin\logic\Admin as AdminLogic;
use app\BaseController;
use app\common\lib\exception\Miss;
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
        return success($token);
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
    public function index()
    {
        $adminList = $this->logic->adminList(
            $this->request->page,
            $this->request->limit
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

    // 添加
    public function update()
    {
        $params = $this->request->params;
        $this->logic->save($params);
        return success('更新成功');
    }
}
