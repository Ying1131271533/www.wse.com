<?php

namespace app\common\validate;

use app\common\validate\BaseValidate;

class Admin extends BaseValidate
{
    // 验证规则
    protected $rule = [
        'id|管理员id'                   => 'require|number|gt:0',
        'username|管理员名称'             => 'require|max:25|min:2|chsDash',
        'real_name|真实姓名'             => 'max:25|min:2',
        'phone|手机'                   => 'mobile',
        'wechat|微信'                  => 'max:28|min:6',
        'password|密码'                => 'require|max:50|min:6',
        'password_confirm|确认密码'      => 'require|confirm:password_confirm',
        // 'password_salt|密码盐'          => 'require|lenght:5',
        'last_login_token|上次登录Token' => 'require',
        'status|状态'                  => 'number',

        // 角色
        'roles|角色'                    => 'array|checkRole',

        // 分页
        'page|页码'                    => 'number|gt:0',
        'limit|条数'                   => 'number|gt:0',

        // 条件
        'start|开始日'                  => 'date',
        'end|截止日'                    => 'date',
        'idReload|ID'                => 'number|gt:0',
        'usernameReload|用户名'         => 'chsDash',

        // ajax
        'value|状态'                   => 'require',

    ];

    // 验证消息
    protected $message = [
        'id.require'       => '管理员id不能为空',
        'password.confirm' => '两次密码不一致',
        'username.confirm' => '两次密码不一致',
    ];

    // 验证场景
    protected $scene = [
        'read'        => ['id'],
        'save'        => [
            'username',
            'real_name',
            'phone',
            'wechat',
            'password',
            'password_confirm',
            'status',
            'roles',
        ],
        'update'      => [
            'id',
            'username',
            'real_name',
            'phone',
            'wechat',
            'roles',
        ],
        'delete'      => [
            'id',
        ],
        'password'    => [
            'id',
            'password',
            'password_confirm',
        ],
        'index'       => ['page', 'limit', 'idReload', 'usernameReload'],
        'login'       => ['username', 'password'],
        'getUserById' => ['id'],
    ];

    // 检查图册
    protected function checkRole($value, $rule = '', $data = [], $field = '', $field_msg = '')
    {
        if (!is_array($value)) {
            return $field . '必需为数组';
        }

        foreach ($value as $role) {
            if (!empty($role)) {
                if (!is_numeric($role)) {
                    throw new \Exception('角色参数有误，必须为整数');
                }
            }
        }
        return true;
    }

    // 用了这里就显示不出来字段的中文别名了
    // public function sceneUpdate()
    // {
    //     // 添加管理员时，增加username的唯一性
    //     return $this->only([
    //         'id',
    //         'username',
    //         'real_name',
    //         'phone',
    //         'wechat',
    //         'password',
    //         'password_confirm',
    //         'status',
    //     ])->append('username', 'unique:admin');
    // }
}
