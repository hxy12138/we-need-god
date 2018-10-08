<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
class User extends Model 
{
    //use SoftDeletes;
    static function getOne($id)
    {
        $row = DB::table('su')->where('id', $id)->first();
        //$row = DB::select("SELECT * FROM news WHERE id='$id'");
        return $row;
    }

    /*
    * 注册添加一条
    */
    static function InsertOneMsg($arr)
    {
        // if (isset($arr['tel'])) {
        //     $sql = "insert into app_user (`u_name`,`u_tel`,`u_pwd`,`u_addtime`) values('?',?,'?',?)";
        // }elseif(isset($arr['mail'])){
        //     $sql = "insert into app_user (`u_name`,`u_mail`,`u_pwd`,`u_addtime`) values('?','?','?',?)";
        // }else{
        //     return 'error';
        // }
        return DB::table('app_user')->insert($arr);
    }

     /*
    * 登陆查询一条
    */
    static function getUserOne($arr)
    {
        $data[':password'] = md5($arr['password']);
        $data[':username'] = $arr['username'];
        $data[':username2'] = $arr['username'];
        return DB::select('select * from `app_user` where (u_tel = :username or u_mail = :username2 ) and u_pwd = :password', $data);
    }

    /*
    * 更新最后一次登录时间
    */
    static function upLastLoginTime($id,$ip,$city,$loginAction)
    {
        $time = time();
        DB::table('app_user')->where('u_id', $id)->update(['u_lastlogintime' => $time]);
        DB::table('app_login_log')->insert([
            'u_id'          =>  $id,
            'login_time'    =>  $time,
            'login_ip'      =>  "{$ip}",
            'login_address' =>  "{$city['region']} {$city['city']}",
            'login_action'  =>  $loginAction
        ]);
        $arr = Db::table('app_login_log')->where('u_id', $id)->get()->toArray();
        return $arr;
        if (count($arr)>10) {
            DB::table('app_login_log')->where('l_id', '=', $arr[0]['l_id'])->delete();
        }
    }
}