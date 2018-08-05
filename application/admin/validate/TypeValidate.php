<?php
namespace app\admin\validate;
use think\Validate;

class TypeValidate extends Validate
{
    protected $rule = [
        'type_name' => 'require|unique:type',
    ];

    protected $message = [
        'type.require' => '商品类型名称必填',
        'type.unique' => '商品类型名称重复',
    ];

    protected $scene = [
        'add' => ['type_name'],
        'upd' => ['type_name'],
    ];
}