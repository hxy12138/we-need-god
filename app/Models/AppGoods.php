<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class AppGoods extends Model
{
    /*
    * 表名
    */
    protected $table = 'app_goods';

    /**
     * 获取列表
     */
    public static function getGoods()
    {
    	return DB::table('app_goods')->get()->toArray();
    }
}
