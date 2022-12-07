<?php

namespace app\common\validate;

class Ajax extends BaseValidate
{
    // 验证规则
    protected $rule = [
        'id|id'      => 'require|number',
        // 'value|修改值'  => '',
        'field|字段名称' => 'require|alphaDash',
        'db|数据表名称'   => 'require|alphaDash'
    ];

    // 验证消息
    protected $message = [
        'id.require' => '数据id不能为空',
    ];

    // 验证场景
    protected $scene = [
        'updateFieldValue' => ['id', 'value', 'field', 'db'],
    ];
}
