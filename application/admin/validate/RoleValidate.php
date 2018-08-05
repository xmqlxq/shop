<?php
namespace app\admin\validate;
use think\Validate;

class RoleValidate extends Validate
{
    // 验证规则
    protected $rule = [
        'role_name' => 'require|unique:role',
    ];

    // 验证不通过的信息
    protected $message = [
        'role_name.require' => '权限名称必填',
        'role_name.unique' => '权限名称重复',
    ];

    // 验证场景
    protected $scene = [
        'add' => ['role_name'],
        'upd' => ['role_name'],
    ];

}