<?php
namespace app\admin\controller;

use app\BaseController;
use app\common\logic\lib\Data as DataLogic;
use think\App;

class Ajax extends BaseController
{
    protected $datalogic = null;

    public function __construct(App $app)
    {
        // 控制器初始化
        parent::__construct($app);
        $this->datalogic = new DataLogic();
    }

    public function updateFieldValue()
    {
        $params = $this->request->params;
        $result = $this->datalogic->changeFieldValue($params);
        return success($result);
    }
}
