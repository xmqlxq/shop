<?php
namespace app\admin\model;

use think\Model;

class Role extends Model{
    //  主键
    protected $pk = 'role_id';
    // 时间戳自动维护
    protected $autoWriteTimestamp = true;

    protected static function init()
    {
        // 入库前的事件
        Role::event('before_insert', function ($role){
            // 把权限数组形式变为
            // 防止没有分配权限没有auth_ids_list属性导致报错, 所以isset判断
            if (isset($role['auth_ids_list'])){
                $role['auth_ids_list'] = implode(',', $role['auth_ids_list']);
            }
        });

        // 编辑前的事件
        Role::event('before_update', function ($role){
            // 把权限数组形式变为字符串形式入库
            // 防止没有分配权限没有auth_ids_list属性导致报错
            if (isset($role['auth_ids_list'])){
                $role['auth_ids_list'] = implode(',',$role['auth_ids_list']);
            }
        });
    }
}