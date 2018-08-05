<?php
namespace app\admin\controller;
use app\admin\model\Attribute;
use app\admin\model\Type;

class AttributeController extends CommonController{

    //属性删除
    public function del(){
        $attr_id = input('attr_id');
        if (Attribute::destroy($attr_id)){
            $this->success('删除成功', url('admin/attr/index'));
        }else{
            $this->error('删除失败');
        }
    }

    // 属性编辑
    public function upd(){
        if (request()->isPost()){
            // 接收参数
            $postData = input('post.');
            // 验证器验证数据

            if ($postData['attr_input_type'] == 1){
                // 如果属性录入方式为列表选择
                $res = $this->validate($postData,'AttributeValidate.add',[],true);
            }else{
                // 属性录入方式为手工输入
                $res = $this->validate($postData,'AttributeValidate.except_attr_values',[],true);
            }
            if ($res !== true){
                // 验证失败
                $this->error(implode(',', $res));
            }
//            halt($postData);
            // 入库
            $attrModel = new Attribute();
            if ($attrModel->update($postData)){
                $this->success('编辑成功','admin/attr/index');
            }else{
                $this->error('编辑失败');
            }
        }

        $attr_id = input('attr_id');
        $attribute = Attribute::find($attr_id);
        // 取出商品属性
        $types = Type::select();
        return $this->fetch('', [
            'attribute' => $attribute,
            'types' => $types
        ]);
    }

    // 属性列表
    public function index(){
        // 取出所有的属性   分配到模板中
        $attributes = Attribute::alias('t1')
                        ->field('t1.*,t2.type_name')
                        ->join('sh_type t2','t1.type_id = t2.type_id', 'left')
                        ->select();
        return $this->fetch('', ['attributes' => $attributes]);
    }

    // 属性添加
    public function add(){
        if (request()->isPost()){
            // 接收参数
            $postData = input('post.');
            // 验证器验证数据

            if ($postData['attr_input_type'] == 1){
                // 如果属性录入方式为列表选择
                $res = $this->validate($postData,'AttributeValidate.add',[],true);
            }else{
                // 属性录入方式为手工输入
                $res = $this->validate($postData,'AttributeValidate.except_attr_values',[],true);
            }
            if ($res !== true){
                // 验证失败
                $this->error(implode(',', $res));
            }

            // 入库
            $attrModel = new Attribute();
            if ($attrModel->allowField(true)->save($postData)){
                $this->success('添加成功','admin/attr/index');
            }else{
                $this->error('添加失败');
            }
        }

        // 取出商品类型
        $types = Type::select();
        return $this->fetch('', ['types' => $types]);
    }
}