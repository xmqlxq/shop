<?php
namespace app\admin\model;
use think\Model;

class Category extends Model{
    protected $pk = 'cat_id';
    protected $autoWriteTimestamp = true;

    // 无限极分类方法
    public function getSonsCat($data,$pid=0,$level=1){
        static $res = [];
        foreach ($data as $k=>$v){
            if ($v['pid'] == $pid){
                $v['level'] = $level;
                $res[$v['cat_id']] = $v;
                unset($data[$k]);
                $this->getSonsCat($data,$v['cat_id'],$level+1);
            }
        }
        return $res;
    }
}