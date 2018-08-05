<?php
namespace app\admin\validate;

use think\Validate;

class AttributeValidate extends Validate{

    protected $rule = [
        'attr_name' => 'require|unique:attribute',
        'type_id' => 'require',
        'attr_values' => 'require',
    ];

    protected  $message = [
        'attr_name.require' => '属性名必填',
        'attr_name.unique' => '属性名重复',
        'type_id.require' => '请选择商品类型',
        'attr_values.require' => '列表选择需要输入属性值',
    ];

    protected $scene = [
        'add' => ['attr_name', 'type_id', 'attr_values'],
        'except_attr_values' => ['attr_name', 'type_id'],
    ];
}