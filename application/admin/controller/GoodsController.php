<?php
namespace app\admin\controller;
use app\admin\model\Category;

class GoodsController extends CommonController{

    // 添加商品
    public function add(){
        // 商品基本信息入库
        if (request()->isPost()){
            // 接收参数
            $postData = input('post.');
            // 验证器验证数据
            $res = $this->validate($postData,'GoodsValidate.add',[],true);

            if ($res !== true){
                // 验证失败
                $this->error(implode(',', $res));
            }

            // 入库
            $goodsModel = new Goods();
            // 上传文件
            $goods_img = $goodsModel->uploadImg();
            if ($goods_img){
                // 把路径写如到数据库(以json格式)
                $postData['goods_img'] = json_encode($goods_img);
            }

            if ($goodsModel->allowField(true)->save($postData)){
                $this->success('添加成功','admin/goods/index');
            }else{
                $this->error('添加失败');
            }
        }


        // 取出所有的无限分类的数据
        $categoryModel = new Category();
        $cates = $categoryModel->getSonsCat($categoryModel->select());
        return $this->fetch('',[
            'cates' => $cates,
        ]);
    }
}