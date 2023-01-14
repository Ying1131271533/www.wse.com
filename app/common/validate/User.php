<?php

namespace app\common\validate;

use app\common\validate\BaseValidate;

class User extends BaseValidate
{
    // 验证规则
    protected $rule = [
        'id|用户id'             => 'require|number|gt:0',
        'username|用户名'        => 'require|max:25|min:4|alphaNum',
        'password|密码'         => 'require|max:50|min:6',
        'company_name|公司名'    => 'require|max:50',
        'contact|联系方式'        => 'require|max:25',
        'contact_type|联系方式类型' => 'require',
        'email|邮箱'            => 'email',
        'telephone|联系电话'      => 'require|max:25',
        'invitation_code|邀请码' => 'length:6',
        'captcha|验证码'         => 'require|length:4',
        'license|营业执照'        => 'max:100',
        'idcard_front|身份证正面照' => 'max:100',
        'idcard_back|身份证反面照'  => 'max:100',
    ];

    // 验证消息
    protected $message = [
        'id.require' => '用户id不能为空',
    ];

    // 验证场景
    protected $scene = [
        'register'          => [
            'username',
            'password',
            'company_name',
            'contact',
            'contact_type',
            'email',
            'telephone',
            'invitation_code',
            'captcha',
            'license',
            'idcard_front',
            'idcard_back',
        ],
        'login'             => ['username', 'password'],
        'getUserById'       => ['id'],
        'getInvitationCode' => ['invitation_code'],
    ];

    // 用户注册 验证场景定义
    public function sceneRegister()
    {
        // 注册时添加username的唯一性
        return $this->only([
            'username',
            'password',
            'company_name',
            'contact',
            'contact_type',
            'email',
            'telephone',
            'invitation_code',
            'captcha',
            'license',
            'idcard_front',
            'idcard_back',
        ])->append('username', 'unique:user');
    }
}
