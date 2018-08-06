<?php
namespace app\home\controller;
use app\home\model\Category;
use think\Controller;

class IndexController extends Controller{

    // 首页
    public function index(){

        // 取出导航的分类数据  导航分类数据只取出顶级分类 即pid=0 同时限制取出的条数
        $categoryModel = new Category();
        $navDatas = $categoryModel->getNavData(5);
        return $this->fetch('', ['navDatas' => $navDatas]);
    }
}