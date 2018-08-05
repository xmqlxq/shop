<?php
namespace app\admin\validate;

use think\Validate;

class GoodsValidate extends Validate{

    protected $rule = [
        'goods_name' => 'require|unique:goods',
        'goods_price' => 'require|gt:0',
        // 正则验证，前面必须加require 规则  正则已经约束了开头^和结尾$
        'goods_number' => 'require|regex:\d+',  // 相当于 ^\d+$
        'cat_id' => 'require',
    ];

    protected $message = [
        'goods_name.require' => '商品名称必填',
        'goods_name.unique'  => '商品名称重复',
        'goods_price.require'     => '商品价格必填',
        'goods_price.gt'     => '商品价格需大于0',
        'goods_number.require' => '库存必填',
        'goods_number.regex' => '库存需大于0',
        'cat_id.require' =>'请选择商品分类',
    ];

    protected $scene = [
        'add' => ['goods_name', 'goods_price', 'goods_number', 'cat_id'],
    ];
}