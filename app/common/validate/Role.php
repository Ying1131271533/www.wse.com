<?php

namespace app\common\validate;

use app\common\validate\BaseValidate;

class Role extends BaseValidate
{
    // 验证规则
    protected $rule = [
        'id|id'        => 'require|number|gt:0',
        'name|角色名称'    => 'require|max:25|chsDash|unique:role',
        'explain|角色描述' => 'max:50',
        'status|状态'    => 'require|number',

        'checkData|选中节点'    => 'array',

    ];

    // 验证场景
    protected $scene = [
        'read'   => ['id'],
        'save'   => [
            'name',
            'explain',
            'status',
        ],
        'update' => [
            'id',
            'name',
            'explain',
            'status',
        ],
        'delete' => ['id'],
        'auth' => ['id', 'checkData'],
    ];
}
