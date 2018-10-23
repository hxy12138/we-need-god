<?php
/**
 * @author 狸猫 <[<823655190@qq.com>]>
 */
namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GoodsController extends Controller
{
    /*
    * 后台展示
    */
    public function showIndex()
    {
        $BackendService = new BackendService();
        $userinfo = $BackendService->getSession();

        return view('admin.index',['userinfo' => $userinfo]);
    }
}
