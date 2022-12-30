<?php

namespace app\common\validate;

use app\common\validate\BaseValidate;

class About extends BaseValidate
{
    // 验证规则
    protected $rule = [
        'id|id'                => 'require|number|gt:0',
        'about_cate_id|分类id' => 'require|number|gt:0',
        'title|标题'           => 'require|max:80|unique:about',
        'author|作者'            => 'max:25',
        'image|封面'             => 'max:100',
        'description|简介'       => 'max:255',
        'content|内容'           => 'require',
        'url|链接'               => 'max:255',
        'sort|排序'              => 'number',
        'status|状态'            => 'require|number',

        // 条件
        'idReload|ID'                => 'number|gt:0',
        'titleReload|标题'         => 'max:80',

    ];

    // 验证场景
    protected $scene = [
        'index' => ['page', 'limit', 'idReload', 'titleReload'],
        'read'   => ['id'],
        'save'   => [
            'about_cate_id',
            'title',
            'author',
            'image',
            'description',
            'content',
            'url',
            'sort',
            'status',
        ],
        'update' => [
            'id',
            'about_cate_id',
            'title',
            'author',
            'image',
            'description',
            'content',
            'url',
            'sort',
            'status',
        ],
        'delete' => ['id'],
    ];
}
