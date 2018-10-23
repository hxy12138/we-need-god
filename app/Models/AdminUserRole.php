<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class AdminUserRole extends Model
{
    /*
    * 表名
    */
    protected $table = 'app_admin_user_role';

    /**
     * 获取用户权限
     */
    public static function getAdminRole($id)
    {
        $admirole = self::leftJoin('app_admin_role', 'app_admin_user_role.role_id', '=', 'app_admin_role.r_id')
                ->where([
                	['app_admin_user_role.admin_id','=', $id],
                	// ['app_admin_user_role.admin_id','=', 1],
                ])
                ->get()
                ->toArray();
        return $admirole;
    }

    /**
     * 添加多条
     */
    public function insertAll($arr)
    {
        return $this->insert($arr);
    }

    /**
     * 删除指定adminID的数据
     */
    public function deleteSomeOne($arr)
    {
        return DB::table('app_admin_user_role')->where($arr)->delete();
    }
}
