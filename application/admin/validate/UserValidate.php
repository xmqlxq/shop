<?php
namespace app\admin\validate;

use think\Validate;

class UserValidate extends Validate
{
    // 定义规则
    protected $rule = [
        'username' => 'require|unique:user',
        'password' => 'require|min:5',
        'repassword' => 'require|confirm:password',
    ];
    // 定义提示信息
    protected $message = [
        'username.require' => '用户名必填',
        'username.unique' => '用户名重复',
        'password.require' => '密码不能为空',
        'password.min'  => '密码必须大于5位',
        'repassword.require' => '确认密码必填',
        'repassword.confirm' => '两次密码不一致',
    ];

    // 验证场景
    protected $scene = [
        'add' => ['username', 'password', 'repassword'],
        'onlyUsername' => ['username'=>'require'],
        'UsernamePassword' => ['username','password','repassword'],
        'login'  => ['username' =>'require', 'password'=>'require'],
    ];

}