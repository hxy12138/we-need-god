<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class AppCategory extends Model
{
    /*
    * 表名
    */
    protected $table = 'app_category';

    /**
     * 获取列表
     */
    public function getCategory()
    {
    	return $this->get()->toArray();
    }
}
