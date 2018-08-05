<?php
namespace app\admin\controller;

use app\admin\model\Role;
use app\admin\model\User;

class UserController extends CommonController
{
    // 用户新增
    public function add()
    {
        if (request()->isPost()){
            $userModel = new User();
            // 接收参数
            $postData = input('post.');
            // 验证器验证数据
            $res = $this->validate($postData,'UserValidate.add',[],true);
            if ($res !== true){
                // 验证失败
                $this->error(implode(',', $res));
            }

            // 入库
            if ($userModel->allowField(true)->save($postData)){
                $this->success('添加成功','admin/user/index');
            }else{
                $this->error('添加失败');
            }
        }

        // 取出所有的角色数据，分配到模板中
        $roles = Role::select();
        return $this->fetch('', ['roles' => $roles]);
    }


    // 展示列表页
    public function index()
    {
        // 获取数据 分页
//        $users = User::paginate(2);
        $users = User::alias('t1')
                ->field('t1.*,t2.role_name')
                ->join('sh_role t2','t1.role_id=t2.role_id', 'left')
                ->paginate(2);
        return $this->fetch('', ['users' => $users]);
    }

    // 用户删除
    public function del()
    {
        // 接收参数
        $user_id = input('user_id');
        // 判断删除是否成功
        if (User::destroy($user_id)){
            $this->success('删除成功',url('admin/user/index'));
        }else{
            $this->error('删除失败');
        }
    }

    // 用户编辑
    public function upd()
    {
        if (request()->isPost())
        {
            $userModel = new User();
            // 接收参数
            $postData = input('post.');
            // 验证器进行验证
            // 当前密码和确认密码都为空的时候  只验证username，保留原来的密码
            if ($postData['password'] == '' && $postData['repassword'] == ''){
                // 验证数据
                $res = $this->validate($postData,'UserValidate.onlyUsername',[],true);
                if ($res !== true){
                    // 验证失败
                    $this->error(implode(',',$res));
                }
            }else{
                $res = $this->validate($postData,'UserValidate.UsernamePassword',[],true);
                if ($res !== true){
                    $this->error(implode(',', $res));
                }
            }
            // 判断编辑是否成功
            if ($userModel->allowField(true)->isUpdate(true)->save($postData)){
                $this->success('编辑成功', url('admin/user/index'));
            }else{
                $this->error('编辑失败');
            }

        }

        $user_id = input('user_id');
        $userData = User::find($user_id);
        return $this->fetch('', ['userData'=>$userData]);
    }
}