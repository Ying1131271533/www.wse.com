<?php

namespace app\common\validate;

use app\common\validate\BaseValidate;

class Category extends BaseValidate
{
    // 验证规则
    protected $rule = [
        'id'             => 'require|number|gt:0',
        'parent_id|父级id' => 'require|number',
        'title|分类标题'     => 'require|max:25|unique:category',
        'url|链接'         => 'max:45',
        'image|图标'       => 'max:100',
        'sort|排序'        => 'max:65535',
        'show|导航显示'      => 'require|number',
        'status|状态'      => 'require|number',

    ];

    // 验证消息
    protected $message = [
        'title.max' => '分类标题不能超过25个字符',
    ];

    // 验证场景
    protected $scene = [
        'read'   => ['id'],
        'save'   => [
            'parent_id',
            'title',
            'url',
            'image',
            'sort',
            'show',
            'status',
        ],
        'update' => [
            'id',
            'parent_id',
            'title',
            'url',
            'image',
            'sort',
            'show',
            'status',
        ],
        'delete' => ['id'],

        // api
    ];
}
