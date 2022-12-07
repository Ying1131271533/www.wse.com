<?php
namespace app\admin\controller;

use app\admin\logic\Admin as AdminLogic;
use app\BaseController;
use app\common\lib\exception\Fail;
use app\common\lib\exception\Params;
use app\common\lib\exception\Token;
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
