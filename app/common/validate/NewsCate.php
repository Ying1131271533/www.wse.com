<?php

namespace app\common\validate;

use app\common\validate\BaseValidate;

class NewsCate extends BaseValidate
{
    // 验证规则
    protected $rule = [
        'id'             => 'require|number|gt:0',
        'cate_name|分类名称' => 'require|max:25|unique:news_cate',
        'sort|排序'        => 'max:65535',
        'status|状态'      => 'require|number',

    ];

    // 验证场景
    protected $scene = [
        'read'   => ['id'],
        'save'   => [
            'cate_name',
            'sort',
            'status'
        ],
        'update' => [
            'id',
            'cate_name',
            'sort',
            'status'
        ],
        'delete' => ['id'],
    ];
}
