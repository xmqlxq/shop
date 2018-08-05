<?php
namespace app\admin\controller;

use app\admin\model\Category;

class CategoryController extends CommonController{

    // 分类删除
    public function del(){
        $cat_id = input('cat_id');
        if (Category::destroy($cat_id)){
            $this->success('删除成功', url('admin/category/index'));
        }else{
            $this->error('删除失败');
        }
    }

    // 分类编辑
    public function upd(){
        if (request()->isPost()){
            // 接收参数
            $postData = input('post.');
            // 验证器验证数据
            $res = $this->validate($postData,'CategoryValidate.upd',[],true);

            if ($res !== true){
                // 验证失败
                $this->error(implode(',', $res));
            }

            // 入库
            $categoryModel = new Category();
            if ($categoryModel->update($postData)){
                $this->success('编辑成功','admin/category/index');
            }else{
                $this->error('编辑失败');
            }
        }

        // 回显数据在表单中
        $cat_id = input('cat_id');
        $categoryModel = new Category();
        $cat = $categoryModel->find($cat_id);
        // 取出无限级递归分类的数据
        $cates = $categoryModel->getSonsCat($categoryModel->select());

        return $this->fetch('', [
           'cat' => $cat,
           'cates' => $cates
        ]);
    }

    // 分类列表
    public function index(){
        $categoryModel = new Category();
        $cats = $categoryModel->getSonsCat($categoryModel->select()->toArray());
        return $this->fetch('', [
            'cats' => $cats,
        ]);
    }

    // 分类添加
    public function add(){
        if (request()->isPost()){
            // 接收参数
           $postData = input('post.');
           // 验证器验证数据
            $res = $this->validate($postData,'CategoryValidate.add',[],true);

            if ($res !== true){
                // 验证失败
                $this->error(implode(',', $res));
            }

            // 入库
            $categoryModel = new Category();
            if ($categoryModel->allowField(true)->save($postData)){
                $this->success('添加成功','admin/category/index');
            }else{
                $this->error('添加失败');
            }
        }

        // 取出无限分类的数据
        $categoryModel = new Category();
        $cates = $categoryModel->getSonsCat($categoryModel->select());
        return $this->fetch('', [
            'cates' => $cates,
        ]);
    }
}