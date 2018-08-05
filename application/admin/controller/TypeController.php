<?php
namespace app\admin\controller;

use app\admin\model\Attribute;
use app\admin\model\Type;

class TypeController extends CommonController{

    // 获取商品类型下的属性
    public function getAttr(){
        $type_id = input('type_id');
        // 只获取type_name的字段
        $type_name = Type::where('type_id','=',$type_id)->value('type_name');
        $attrbutes = Attribute::where('type_id', '=', $type_id)->select();
        return $this->fetch('', ['attributes'=>$attrbutes,'type_name' => $type_name]);
    }

    //商品类型删除
    public function del(){
        $type_id = input('type_id');
        if (Type::destroy($type_id)){
            $this->success('删除成功', url('admin/type/index'));
        }else{
            $this->error('删除失败');
        }
    }

    // 商品类型编辑
    public function upd(){

        // 判断是否是post提交
        if (request()->isPost()){
            // 接收参数
            $postData = input('post.');
            // 验证参数
            $res = $this->validate($postData, 'TypeValidate.upd', [], true);
            if ($res !== true){
                $this->error(implode(',', $res));
            }
            // 写如数据库
            $typeModel = new Type();
            if ($typeModel->update($postData)){
                $this->success('编辑成功', url('admin/type/index'));
            }else{
                $this->error('编辑失败');
            }
        }

        $type_id = input('type_id');
        $type = Type::find($type_id);
        return $this->fetch('', ['type' => $type]);
    }

    // 商品类型列表
    public function index(){
        $types = Type::select();
        return $this->fetch('', ['types'=>$types]);
    }

    // 商品类型添加
    public function add()
    {
        if (request()->isPost()){
            // 接收参数
            $postData = input('post.');
            // 验证器验证数据
            $res = $this->validate($postData,'TypeValidate.add',[],true);
            if ($res !== true){
                // 验证失败
                $this->error(implode(',', $res));
            }

            // 入库
            $typeModel = new Type();
            if ($typeModel->allowField(true)->save($postData)){
                $this->success('添加成功','admin/type/index');
            }else{
                $this->error('添加失败');
            }
        }
        return $this->fetch('');
    }
}