<?php

namespace app\common\validate;

use app\common\validate\BaseValidate;

class CustomerService extends BaseValidate
{
    // 验证规则
    protected $rule = [
        'id'               => 'require|number|gt:0',
        'name|客服名称'        => 'require|max:25|unique:customer_service',
        'real_name|真实姓名'   => 'max:25',
        'qq|QQ号码'          => 'require|max:15',
        'wechat|微信号'       => 'max:50',
        'phone|手机号码'       => 'mobile',
        'description|客服描述' => 'max:255',
        'sort|排序'          => 'max:65535',
        'status|状态'        => 'require|number'

    ];

    // 验证场景
    protected $scene = [
        'read'   => ['id'],
        'save'   => [
            'name',
            'real_name',
            'qq',
            'wechat',
            'phone',
            'description',
            'sort',
            'status'
        ],
        'update' => [
            'id',
            'name',
            'real_name',
            'qq',
            'wechat',
            'phone',
            'description',
            'sort',
            'status'
        ],
        'delete' => ['id'],
    ];
}
