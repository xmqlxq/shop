<?php
namespace app\admin\controller;
use app\admin\model\Attribute;
use app\admin\model\Category;
use app\admin\model\Goods;
use app\admin\model\Type;

class GoodsController extends CommonController{

    // 商品列表页
    public function index(){
        $goods = Goods::alias('t1')
            ->field("t1.*,t2.cat_name")
            ->join('sh_category t2','t1.cat_id=t2.cat_id','left')
            ->select();

        return $this->fetch('',['goods' => $goods]);
    }

    // 获取商品类型的所有属性
    public function getTypeAttr(){
        if (request()->isAjax()){
            $type_id = input('type_id');
            // 取出属性表中对应的类型的数据  返回json格式
            $attribute = Attribute::where('type_id', '=', $type_id)->select();
            echo json_encode($attribute);die();
        }
    }

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
//            halt($_FILES);
            // 入库
            $goodsModel = new Goods();
            // 上传文件
//            halt(request()->file());
            $goods_img = $goodsModel->uploadImg();  // 返回  [20180805/xxx.jpg,20180805/xxx.jpg,]
            if ($goods_img){
//                halt($goods_img);
                // 说明有原图传递过来 对其进行缩略图处理
                $thumb = $goodsModel->thumb($goods_img);
                // 把路径写如到数据库(以json格式)
                $postData['goods_img'] = json_encode($goods_img);
                // 生成缩略图
                $postData['goods_middle'] = json_encode($thumb['goods_middle']);
                $postData['goods_thumb']  = json_encode($thumb['goods_thumb']);
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

        // 取出商品的类型
        $types = Type::select();
        return $this->fetch('',[
            'cates' => $cates,
            'types' => $types,
        ]);
    }
}