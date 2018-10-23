<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\AdminUserRole;
use DB;

class AdminUser extends Model
{
    /*
    * 表名
    */
    protected $table = 'app_admin_user';

     /*
    * 登陆查询一条
    */
    public function getUserOneForLogin($arr)
    {
        return DB::select('select * from `app_admin_user` where username = :username and password = :password and is_freeze=1 and is_del=0', $arr);
    }

    /**
     * 获取用户信息
     */
    public function getUserInfo($id)
    {
        return DB::table('app_admin_user')->where([
            ['id', '=', $id],
            ['is_freeze', '=', '1'],
            ['is_del', '=', '0'],
        ])->select('id','username','name','created_at','updated_at')->first();
    }

    /**
     * 获取所有管理员
     */
    public function getUser()
    {
        return self::where(['is_del'=>'0'])->select("id","username","name","is_freeze","is_super","created_at","updated_at")->get()->toArray();
    }

    /**
     * 添加管理员
     */
    public function addUser($arr)
    {
        return $this->insert($arr);
    }

    /**
     * 上一条添加ID
     */
    public function insertID()
    {
        return DB::getPdo()->lastInsertId();
    }

    /**
     * 修改状态
     */
    public function chengStatus($arr)
    {
        return $this->where('id', $arr['id'])
        ->update(['is_freeze' => $arr['status']]);
    }

    /**
     * 通过id查用户信息
     */
    public function getUserOneForId($id)
    {
        return $this->where('id',$id)->first()->toArray();
    }

    /**
     * 修改用户信息
     */
    public function updateUser($arr)
    {
        return $this->where('id', $arr['id'])
        ->update($arr);
    }

    /**
     * 假删除
     */
    public function delUser($arr)
    {
        return $this->where('id', $arr['id'])
        ->update($arr);
    }
}
