<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
