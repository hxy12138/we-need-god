<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class AdminMenu extends Model
{
    /*
    * 表名
    */
    protected $table = 'app_admin_menu';

    /**
     * 获取所有菜单
     */
    public function getAllMenu()
    {
    	return $this->where(['is_menu'=>'1'])->get()->toArray();
    }

    /**
     * 上一条添加ID
     */
    public function lastInsertId()
    {
        return DB::getPdo()->lastInsertId();
    }

    /**
     * 获取父级权限
     */
    public function getParentMenu()
    {
    	return $this->where(['p_id'=>'0','is_menu'=>'1'])->get()->toArray();
    }

    /**
     * 添加权限
     */
    public function insertMenu($arr)
    {
        return $this->insert($arr);
    }

    /**
     * 修改path字段
     */
    public function updatePath($arr)
    {
    	return DB::table('app_admin_menu')->where('id',$arr['id'])->update(['path' => $arr['path']]);
    }

    /**
     * 获取某个权限的信息
     */
    public function getOneMenu($arr)
    {
    	return $this->where($arr)->first()->toArray();
    }

    /**
     * 修改权限
     */
    public function updateMenu($arr)
    {
    	return DB::table('app_admin_menu')->where('id',$arr['id'])->update($arr);
    }

    /**
     * 删除权限
     */
    public function delMenu($arr)
    {
        return DB::table('app_admin_menu')->where($arr)->delete();
    }
}
