<?php

namespace app\common\validate;

use app\common\validate\BaseValidate;

class Admin extends BaseValidate
{
    // 验证规则
    protected $rule = [
        'id|管理员id'                   => 'require|number|gt:0',
        'username|管理员名称'             => 'require|max:25|min:2',
        'real_name|真实姓名'             => 'max:25|min:2',
        'phone|手机'                   => 'mobile',
        'wechat|微信'                  => 'max:28|min:6',
        'password|密码'                => 'require|max:50|min:6',
        'password_confirm|确认密码'         => 'require|max:50|min:6|confirm:password',
        'password_salt|密码盐'          => 'require|lenght:5',
        'last_login_token|上次登录Token' => 'require',
        'status|状态'                  => 'number',

        // 分页
        'page|页码'                  => 'number|gt:0',
        'limit|条数'                  => 'number|gt:0',
    ];

    // 验证消息
    protected $message = [
        'id.require' => '管理员id不能为空',
        'password_confirm.confirm' => '两次密码不一致',
    ];

    // 验证场景
    protected $scene = [
        'save'        => [
            'username',
            'real_name',
            'phone',
            'wechat',
            'password',
            'password_confirm',
            'status'
        ],
        'index'       => ['page', 'limit'],
        'login'       => ['username', 'password'],
        'getUserById' => ['id'],
    ];

    // save 验证场景定义
    // 用了这里就显示不出来字段的中文别名了
    // public function sceneSave()
    // {
    //     // 添加管理员时，增加username的唯一性
    //     return $this->only(['username', 'real_name', 'phone', 'wechat', 'password', 'status'])->append('username', 'unique:admin');
    // }
}
