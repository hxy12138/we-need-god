<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminRoleResource extends Model
{
    /*
    * 表名
    */
    protected $table = 'app_admin_role_resource';
    
    /**
     * 获取角色菜单资源
     */
    public static function getRoleMenu($arr)
    {
    	// return $str;
    	$result = self::leftJoin('app_admin_menu', 'app_admin_role_resource.resource_id', '=', 'app_admin_menu.id')
                ->whereIn('app_admin_role_resource.role_id', $arr)
                ->where('app_admin_role_resource.type','1')
                ->distinct('app_admin_role_resource.resource_id')
                ->get()
                ->toArray();
    	return $result;
    }

    /**
     * 获取角色按钮资源
     */
    public static function getRoleButton($arr)
    {
        $result = self::leftJoin('app_admin_button', 'app_admin_role_resource.resource_id', '=', 'app_admin_button.button_id')
                ->whereIn('app_admin_role_resource.role_id', $arr)
                ->where('app_admin_role_resource.type','0')
                ->distinct('app_admin_role_resource.resource_id')
                ->get()
                ->toArray();
        return $result;
    }
}
