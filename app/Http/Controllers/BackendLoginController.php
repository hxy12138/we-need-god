<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\Services\BackendService;

class BackendLoginController extends Controller
{
    /*
    * 后台登陆展示
    */
    public function showLogin()
    {
    	return view('admin.login');
    }

    /*
    * 后台登陆处理
    */
    public function loginDo(Request $request)
    {
        $BackendService = new BackendService();
    	if ($request->isMethod('post')){
			$arr = Input::post();
			$result = $BackendService->logonJudgement($arr);
    		if (!$result) {
    			return redirect("admin/login");
    		}
            $BackendService->saveUserLandingStatus(['userinfo'=>$result,'remember'=>isset($arr['remember'])?true:false]);
    		return redirect("admin/home");
        }
        
        return 'Incorrect!';
    }

	/*
	* 退出登陆
	*/
	public function adminLoginout()
	{
        $BackendService = new BackendService();
		$BackendService->delUserLandingStatus();
		return redirect("admin/login");
	}
}
