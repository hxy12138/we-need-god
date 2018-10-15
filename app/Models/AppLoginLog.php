<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class AppLoginLog extends Model
{
	/**
	 * 表名
	 */
    protected $table = 'app_login_log';
    
    /**
     * 添加一条
     */
    static function add($array)
    {
    	return DB::table('app_login_log')->insert([
            'u_id'          =>  $array['u_id'],
            'login_time'    =>  $array['login_time'],
            'login_ip'      =>  "{$array['login_ip']}",
            'login_address' =>  $array['login_address'],
            'login_action'  =>  $array['login_action']
        ]);
    }

    /**
     * 查询数据按主键从小到大排序
     */
    static function getDataAce($id)
    {
    	return DB::table('app_login_log')->where('u_id', $id)->orderBy('l_id', 'asc')->get()->toArray();
    }

    /**
     * 删除一条数据
     */
    static function deleteOne($id)
    {
    	return DB::table('app_login_log')->where('l_id', $id)->delete();
    }
}
