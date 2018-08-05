<?php
namespace app\admin\model;

use think\Model;

class User extends Model
{
    // 主键
    protected $pk = 'user_id';
    // 时间戳自动维护
    protected $autoWriteTimestamp = true;

    public static function init()
    {
        // 入库前的事件
        User::event('before_insert', function ($user){
            // 将密码加密
            $user['password'] = md5($user['password'].config('password_salt'));
        });
        User::event('before_update', function ($user){
            // 如果更新的时候密码没有填写，即不修改密码，则去掉password数据
            if ($user['password'] == ''){
                unset($user['password']);
            }else{
                $user['password'] = md5($user['password'].config('password_salt'));
            }
        });
    }

    // 检测用户和密码是否匹配
    public function checkUser($username,$password)
    {
        $where = [
            'username' => $username,
            'password' => md5($password.config('password_salt')),
        ];
        $userInfo = $this->where($where)->find();
        if ($userInfo){
            // 用户名和密码匹配
            session('user_id', $userInfo['user_id']);
            session('username', $userInfo['username']);
            // 通过用户的角色role_id 把当前用户的权限写入到session中
            $this->getAuthWriteSession($userInfo['role_id']);
            return true;
        }else{
            return false;
        }
    }

    public function getAuthWriteSession($role_id){
        // 获取角色表中的auth_ids_list字段的值
        $auth_ids_list = Role::where('role_id', '=', $role_id)->value('auth_ids_list');
        // 如果是超级管理员   $auth_ids_list => *
        if ($auth_ids_list == '*'){
            $oldAuths = Auth::select()->toArray();
        }else{
            // 如果是非超级管理员，只能取出已有的权限  如： $auth_ids_list  => 1,2,3,4
            $oldAuths = Auth::where('auth_id','in', $auth_ids_list)->select()->toArray();
        }

        // 两个技巧
        // 1.每个数组的auth_id作为二维数组的下标
        $auths = [];
        foreach ($oldAuths as $v){
            $auths[$v['auth_id']] = $v;
        }
        // 2.通过pid进行分组
        $children = [];
        foreach ($oldAuths as $vv){
            $children[$vv['pid']][] = $vv['auth_id'];
        }
        // 写入到session中
        session('auths', $auths);
        session('children', $children);

        // 写如管理员可访问的权限到 session中  防权限翻墙
        if ($auth_ids_list == '*'){
            // 超级管理员
            session('visitorAuth', '*');
        }else{
            // 非超级管理员 形式：[auth/add, auth/index]
            $visitorAuth = [];
            foreach ($oldAuths as $v){
                $visitorAuth[] = strtolower($v['auth_c'].'/'.$v['auth_a']);
            }
            session('visitorAuth', $visitorAuth);
        }
    }
}