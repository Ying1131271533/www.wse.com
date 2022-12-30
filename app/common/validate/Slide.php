<?php

namespace app\common\validate;

use app\common\validate\BaseValidate;

class Slide extends BaseValidate
{
    // 验证规则
    protected $rule = [
        'id|id'                => 'require|number|gt:0',
        'category_id|分类id' => 'require|number|gt:0',
        'title|标题'           => 'require|max:80|unique:slide',
        'url|链接'               => 'max:255',
        'sort|排序'              => 'number',
        'status|状态'            => 'require|number',
        'imgs|图片'             => 'require',

        // 条件
        'idReload|ID'                => 'number|gt:0',
        'titleReload|标题'         => 'max:80',

    ];

    // 验证场景
    protected $scene = [
        'index' => ['page', 'limit', 'idReload', 'titleReload'],
        'read'   => ['id'],
        'save'   => [
            'category_id',
            'title',
            'url',
            'sort',
            'status',
            'imgs'
        ],
        'update' => [
            'id',
            'category_id',
            'title',
            'url',
            'sort',
            'status',
            'imgs'
        ],
        'delete' => ['id'],
    ];
}
