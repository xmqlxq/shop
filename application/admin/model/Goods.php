<?php
namespace app\admin\model;

use think\Db;
use think\Model;

class Goods extends Model{
    protected $pk = 'goods_id';
    protected $autoWriteTimestamp = true;

    protected static function init()
    {
        // 入库前的事件
        Goods::event('before_insert', function ($goods){
            // 设置货号唯一
            $goods['goods_sn'] = date('ymdhis').uniqid();
        });
        // 入库之后的事件   把商品属性入库到商品属性表
        Goods::event('after_insert', function ($goods){
            // $goods 当表单对象数据入库成功后  返回表的记录数据对象   自带主键 goods_id
            $goods_id = $goods['goods_id'];
            $postData = input('post.');
            $goodsAttrValue = $postData['goodsAttrValue'];
            $goodsAttrPrice = $postData['goodsAttrPrice'];

            // 有多个属性  需循环添加
            foreach ($goodsAttrValue as $attr_id=>$attr_value){
                if (is_array($attr_value)){
                    // 是数组的时候  则是单选属性
                    foreach ($attr_value as $k => $single_attr_value){
                        $data = [
                            'goods_id' => $goods_id,
                            'attr_id'  => $attr_id,
                            'attr_value' => $single_attr_value,
                            'attr_price' => $goodsAttrPrice[$attr_id][$k],
                            'create_time' => time(),
                            'update_time' => time(),
                        ];

                        // 入库到商品属性表
                        Db::name('goods_attr')->insert($data);
                    }
                }else{
                    // 唯一属性$attr_value是一个字符串
                    $data = [
                        'goods_id' => $goods_id,
                        'attr_id'  => $attr_id,
                        'attr_value' => $attr_value,
                        'create_time' => time(),
                        'update_time' => time(),
                    ];
                    // 入库到商品属性表
                    Db::name('goods_attr')->insert($data);
                }
            }

        });
    }

    // 文件上传
    public function uploadImg(){
        $goods_img = []; // 用于存储文件上传的路径
        // 接收上传文件的name 的名称
        $files = request()->file('img');
        if ($files){
            // 文件上传要求
            $validate = [
                'size' => 3*1024*1024,
                'ext' => 'jpg,png,gif,jpeg',
            ];
            // 上传的目录
            $uploadDir = './static/upload/';
            foreach ($files as $file){
                $info = $file->validate($validate)->move($uploadDir);
                if ($info){
                    // 存储文件的路径到数组中去，把反斜杠替换成正斜杠
                    $goods_img[] = str_replace('\\','/',$info->getSaveName());
                }
            }
        }
        return $goods_img;
    }

    // 进行缩略图的生成
    public function thumb($goods_img){

        $goods_middle = [];
        $goods_thumb = [];

        // 350*350的图片
        foreach ($goods_img as $path){
            $arr_path = explode('/', $path);
            $middle_path = $arr_path[0].'/middle_'.$arr_path[1];
//            halt($path);
            // 打开原图的路径
            $image = \think\Image::open("./static/upload/".$path);
            // 第三个参数2 填充补白
            $image->thumb(350,350,2)->save("./static/upload/".$middle_path);
            // 存储图片的中等图片
            $goods_middle[] = $middle_path;
        }

        // 50*50的图片
        foreach ($goods_img as $path){
            $arr_path = explode('/', $path);
            $thumb_path = $arr_path[0].'/thumb_'.$arr_path[1];
            // 打开原图的路径
            $image = \think\Image::open("./static/upload/".$path);
            // 第三个参数2 填充补白
            $image->thumb(50,50,2)->save("./static/upload/".$thumb_path);
            // 存储图片的中等图片
            $goods_thumb[] = $thumb_path;
        }
        // 返回路径
        return ['goods_middle'=>$goods_middle,'goods_thumb'=>$goods_thumb];
    }
}