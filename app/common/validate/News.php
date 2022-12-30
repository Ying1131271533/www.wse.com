<?php

namespace app\common\validate;

use app\common\validate\BaseValidate;

class News extends BaseValidate
{
    // 验证规则
    protected $rule = [
        'id|id'                => 'require|number|gt:0',
        'news_cate_id|分类id' => 'require|number|gt:0',
        'title|新闻标题'           => 'require|max:80|unique:news',
        'author|作者'            => 'max:25',
        'image|封面'             => 'require',
        'description|简介'       => 'require|max:255',
        'content|内容'           => 'require',
        'url|链接'               => 'max:255',
        'sort|排序'              => 'number',
        'status|状态'            => 'require|number',

        // 条件
        'idReload|ID'                => 'number|gt:0',
        'titleReload|新闻标题'         => 'max:80',

    ];

    // 验证消息
    protected $message = [
        'level.max' => '目前层级只有0和1级',
    ];

    // 验证场景
    protected $scene = [
        'index' => ['page', 'limit', 'idReload', 'titleReload'],
        'read'   => ['id'],
        'save'   => [
            'news_cate_id',
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
            'news_cate_id',
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
