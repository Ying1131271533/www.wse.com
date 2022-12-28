<?php

namespace app\common\validate;

use app\common\validate\BaseValidate;

class Node extends BaseValidate
{
    // 验证规则
    protected $rule = [
        'id|id'          => 'require|number|gt:0',
        'parent_id|父级id' => 'require|number',
        'name|节点名称'        => 'require|max:45|unique:node',
        'title|节点标题'     => 'require|max:25',
        'url|url'        => 'require|max:45|unique:node|alpha',
        'view|节点视图'      => 'max:50',
        'level|层级'       => 'number',
        'icon|图标'        => 'max:50',
        'sort|排序'        => 'max:65535',
        'show|导航显示'      => 'require|number',
        'refresh|刷新'     => 'require|number',
        'status|状态'      => 'require|number',

    ];

    // 验证消息
    protected $message = [
        'level.max' => '目前层级只有0和1级',
    ];

    // 验证场景
    protected $scene = [
        'read'   => ['id'],
        'save'   => [
            'parent_id',
            'name',
            'title',
            // 'url',
            'view',
            'level',
            'icon',
            'sort',
            'show',
            'refresh',
            'status',
        ],
        'update' => [
            'id',
            'parent_id',
            'name',
            'title',
            // 'url',
            'view',
            'level',
            'icon',
            'sort',
            'show',
            'refresh',
            'status',
        ],
        'delete' => ['id'],
    ];
}
