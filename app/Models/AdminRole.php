<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class AdminRole extends Model
{
    /*
    * 表名
    */
    protected $table = 'app_admin_role';

    /**
     * 获取所有管理员
     */
    public function getRole()
    {
        return $this->get()->toArray();
    }

    /**
     * 添加角色
     */
    public function addRole($arr)
    {
        return $this->insert($arr);
    }

    /**
     * 上一条添加ID
     */
    public function lastInsertId()
    {
        return DB::getPdo()->lastInsertId();
    }

    /**
     * 获取某个角色
     */
    public function getOneRole($arr)
    {
        return $this->where($arr)->first()->toArray();
    }

    /**
     * 获取某个角色的资源
     */
    public function getOneRoleResource($arr)
    {
        return $this->leftJoin('app_admin_role_resource','app_admin_role.r_id','=','app_admin_role_resource.role_id')
        ->where('app_admin_role.r_id',$arr['role_id'])
        ->get()
        ->toArray();
    }

    /**
     * 修改角色名字
     */
    public function updataRole($arr)
    {
        return DB::table('app_admin_role')->where(['r_id'=>$arr['r_id']])->update(['role_name'=>$arr['role_name']]);
    }

    /**
     * 删除角色
     */
    public function deleteRole($id)
    {
        return DB::table('app_admin_role')->where($id)->delete();
    }
}
