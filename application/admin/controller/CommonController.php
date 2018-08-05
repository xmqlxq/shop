<?php
namespace app\admin\controller;
use think\Controller;

class CommonController extends Controller
{
    public function _initialize()
    {
        if (!session('user_id')){
            $this->error('请先登录', url('admin/public/login'));
        }else{
            // 登录没有翻墙   防止权限翻墙
            // 获取session中的权限
            $visitorAuth = session('visitorAuth');
            // 拼接获取到当前访问的控制器名和方法名 转为小写
            $now_ca = strtolower(request()->controller().'/'.request()->action());
            // 判断访问的控制器和方法是否在session里面
            // 超级管理员不做权限控制
            if ($visitorAuth == '*' || strtolower(request()->controller()) == 'index')
            {
                return ;
            }
            if (!in_array($now_ca,$visitorAuth)){
                $this->error('访问错误');
            }

        }
    }
}