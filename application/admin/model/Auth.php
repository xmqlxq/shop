<?php
namespace app\admin\model;
use think\Model;

class Auth extends Model
{
    // 指定表
    protected $table = 'sh_auth';
    // 指定主键
    protected $pk = 'auth_id';
    // 时间戳自动维护
    protected $autoWriteTimestamp = true;

    public function getSonsAuth($data,$pid=0,$level=1){
        static $res = [];
        foreach ($data as $k => $v)
        {
            if ($v['pid'] == $pid){
                $v['level'] = $level;
                $res[] = $v;
                unset($data[$k]);
                $this->getSonsAuth($data,$v['auth_id'],$level+1);
            }
        }
        return $res;
    }

    protected static function init()
    {
        Auth::event('before_update', function ($auth){
            // 如果权限为顶级的时候，需把控制器名和方法名清空之后才入库
            if ($auth['pid'] == 0){
                $auth['auth_c'] = '';
                $auth['auth_a'] = '';
            }
        });
    }
}