<?php
namespace app\home\model;
use think\Model;

class Category extends Model{
    protected $pk = 'cat_id';

    // 获取导航栏的分类数据 只取出pid为0的数据 并且限制条数
    public function getNavData($limit){
        return $this->where('is_show','=','1')->limit($limit)->select();
    }
}