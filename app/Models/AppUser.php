<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class AppUser extends Model
{
	 protected $table = 'app_user';
    static function getOne($id)
    {
        $row = DB::table('su')->where('id', $id)->first();
        return $row;
    }

    /*
    * 注册添加一条
    */
    static function add($arr)
    {
        return DB::table('app_user')->insert($arr);
    }

     /*
    * 登陆查询一条
    */
    static function getUserOneForLogin($arr)
    {
        $data[':password'] = md5($arr['password']);
        $data[':username'] = $arr['username'];
        $data[':username2'] = $arr['username'];
        return DB::select('select * from `app_user` where (u_tel = :username or u_mail = :username2 ) and u_pwd = :password', $data);
    }

    /*
    * 更新最后一次登录时间
    */
    static function upLastLoginTime($id)
    {
        $time = time();
        return DB::table('app_user')->where('u_id', $id)->update(['u_lastlogintime' => $time]);
    }
}
