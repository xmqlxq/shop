<?php
namespace app\admin\controller;
use app\admin\model\Auth;
class AuthController extends CommonController{

    // 用户权限删除
    public function del(){
        // 接收参数
        $auth_id = input('auth_id');
        // 判断是否删除成功
        if (Auth::destroy($auth_id)){
            $this->success('删除成功', url('admin/auth/index'));
        }else{
            $this->error('删除失败');
        }
    }

    // 用户权限编辑
    public function upd(){

        $authModel = new Auth();
        if (request()->isPost()){
            // 接收参数
            $postData = input('post.');
            // 判断权限名称和父类权限相同
            if ($postData['auth_id'] == $postData['pid']){
                $this->error('权限不能是自己的父类权限');
            }
            // 判断是否是父类顶级分类
            if ($postData['pid'] == 0){
                $res = $this->validate($postData,'AuthValidate.onlyAuthName', [], true);
            }else{
                $res = $this->validate($postData, 'AuthValidate.upd', [], true);
            }

            // 判断是否验证失败
            if ($res !== true){
                $this->error(implode(',', $res));
            }
            // 判断入库是否成功
            if ($authModel->update($postData)){
                $this->success('编辑成功',url('admin/auth/index'));
            }else{
                $this->error('编辑失败');
            }
        }

        // 查出所有的权限

        $auths = $authModel->getSonsAuth($authModel->select());
        // 接收参数，查出该条数据
        $auth_id = input('auth_id');
        $auth_ = Auth::find($auth_id);
        return $this->fetch('',['auths' => $auths,'auth_' => $auth_]);
    }

    // 权限添加
    public function add()
    {
        $authModel = new Auth();
        if (request()->isPost()){
            // 接收参数
            $postData = input('post.');
            if ($postData['pid'] == 0){
                $res = $this->validate($postData,'AuthValidate.onlyAuthName',[],true);
            }else{
                $res = $this->validate($postData, 'AuthValidate.add',[],true);
            }
            // 验证失败
            if ($res !== true ){
                $this->error(implode(',', $res));
            }
            // 判断入库是否成功
            if ($authModel->save($postData)){
                $this->success('添加成功',url('admin/auth/index'));
            }else{
                $this->error('添加失败');
            }

        }
        // 查询出所有的权限
        $auths = $authModel->getSonsAuth( $authModel->select() );
        return $this->fetch('', ['auths' => $auths]);
    }

    // 用户权限列表
    public function index()
    {
        // 查询出所有的数据
        $auths = Auth::field('t1.*,t2.auth_name p_name')
            ->alias('t1')
            ->join('sh_auth t2','t1.pid =t2.auth_id', 'left')
            ->select();
        $authModel = new Auth();
        // 得到整理后的数据
        $auths = $authModel->getSonsAuth($auths);
        return $this->fetch('',['auths' => $auths]);
    }

}