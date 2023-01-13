<?php

namespace app\common\validate;

use app\common\validate\BaseValidate;

class Product extends BaseValidate
{
    // 验证规则
    protected $rule = [
        'id|id'            => 'require|number|gt:0',
        'title|文章标题'       => 'require|max:80|unique:product',
        'image|封面'         => 'max:100',
        'content|内容'       => 'require',
        'sort|排序'          => 'number',
        'status|状态'        => 'require|number',

        // 条件
        'idReload|ID'      => 'number|gt:0',
        'titleReload|文章标题' => 'max:80',

        // 分页
        'page|页码'          => 'number|gt:0',
        'limit|条数'         => 'number|gt:0',
    ];

    // 验证场景
    protected $scene = [
        // admin
        'index'          => ['page', 'limit', 'idReload', 'titleReload'],
        'read'           => ['id'],
        'save'           => [
            'title',
            'image',
            'content',
            'sort',
            'status'
        ],
        'update'         => [
            'id',
            'title',
            'image',
            'content',
            'sort',
            'status'
        ],
        'delete'         => ['id'],

        // api
        'getProductList' => ['page', 'limit'],
        'getBasicInfo'   => ['id'],
    ];
}
