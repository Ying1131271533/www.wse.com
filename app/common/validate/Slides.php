<?php

namespace app\common\validate;

use app\common\validate\BaseValidate;

class Slides extends BaseValidate
{
    // 验证规则
    protected $rule = [
        'id|id'            => 'require|number|gt:0',
        'category_id|分类id' => 'require|number|gt:0',
        'title|标题'         => 'max:80',
        'url|链接'           => 'max:255',
        'sort|排序'          => 'number',
        'status|状态'        => 'require|number',
        'image|轮播图'         => 'require'
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
            'image',
        ],
        'update' => [
            'id',
            'category_id',
            'title',
            'url',
            'sort',
            'status',
            'image',
        ],
        'delete' => ['id'],
        'getSlidesList' => ['category_id'],
    ];
}
