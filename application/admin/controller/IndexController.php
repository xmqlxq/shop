<?php
namespace app\admin\controller;

use think\Controller;

class IndexController extends CommonController
{
    //后台首页
    public function index()
    {
        return $this->fetch();
    }
    // 首页上部分
    public function top()
    {
        return $this->fetch();
    }
    // 首页左边
    public function left()
    {
        return $this->fetch();
    }
    // 首页主要部分
    public function main()
    {
        return $this->fetch();
    }

}