<?php
namespace app\admin\controller;

use app\admin\model\User;
use think\Controller;

class PublicController extends Controller
{

    // 登录
    public function login()
    {
        // 判断是否是post提交
        if (request()->isPost())
        {
            // 接收参数
            $postData = input('post.');
            //验证器验证数据
            $res = $this->validate($postData,'UserValidate.login',[], true);
            if ($res !== true)
            {
                $this->error(implode(',', $res));
            }
            // 判断是否登录成功
            $userModel = new User();
            if ($userModel->checkUser($postData['username'],$postData['password'])){
                $this->redirect('/ht');
            }else{
                $this->error('用户名或密码错误');
            }
        }
        return $this->fetch('');
    }

    // 退出登录
    public function logout(){
        session('user_id',null);
        session('username',null);
        $this->redirect('/admin/public/login');
    }
}