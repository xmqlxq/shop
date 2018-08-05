<?php
namespace app\admin\model;

use think\Model;

class Goods extends Model{
    protected $pk = 'goods_id';
    protected $autoWriteTimestamp = true;


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
                    $goods_img[] = str_replace('\\','/',$info->getSaveName);
                }
            }
        }
        return $goods_img;
    }
}