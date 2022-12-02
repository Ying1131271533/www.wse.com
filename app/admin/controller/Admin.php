<?php
namespace app\admin\controller;

use app\admin\logic\Admin as AdminLogic;
use app\BaseController;
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
        return $this->success($params);
    }

    // 列表
    public function index()
    {
        $params = $this->request->params;
        // halt($params);
        $data = $this->logic->adminList($params);
        return $this->success($data);
    }

    // 添加
    public function save()
    {
        $params = $this->request->params;
        $this->logic->save($params);
        return $this->success('保存成功');
    }
}
