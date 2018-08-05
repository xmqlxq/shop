<?php
namespace app\admin\validate;
use think\Validate;

class AuthValidate extends Validate{
    // 验证规则
    protected $rule = [
        'auth_name' => 'require|unique:auth',
        'auth_c' => 'require',
        'auth_a' => 'require',
    ];

    // 定义验证信息
    protected $message = [
        'auth_name.require' => '权限名称必填',
        'auth_name.unique' => '权限名称重复',
        'auth_c.require' => '控制器名必填',
        'auth_a.require' => '方法名必填',
    ];

    // 定义场景
    protected $scene = [
        'add' => ['auth_name','auth_c','auth_a'],
        'onlyAuthName' => ['auth_name'],
        'upd' => ['auth_name' => 'require','auth_c','auth_a'],
    ];
}