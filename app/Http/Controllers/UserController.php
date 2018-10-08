<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use App\Services\UserService;

class UserController extends Controller
{
	/*
	*展示用户登录页面
	*/ 
	public function showUserLogin()
	{
 		return view('user.login');
	}

	/*
	* 接收处理用户登录页面
	*/ 
	public function doUserLogin(Request $request)
	{
 		if ($request->isMethod('post')){
			$arr = Input::post();
			//dd($arr);
			// $ss = UserService::LogonJudgement($arr);
			// dd($ss);
			if (!(UserService::LogonJudgement($arr)==[])) {
				return redirect("/prompt")->with(['message'=>'登录成功！','url' =>'/', 'jumpTime'=>5,'status'=>'success']);
			}else{
				return redirect("/prompt")->with(['message'=>'登录失败！','url' =>'/login', 'jumpTime'=>5,'status'=>'error']);
			}
        }else{
        	return 'Incorrect!';
        }
	}

	/*
	* 用户注册展示
	*/ 
	public function showUserRegister()
	{
		return view('user.register');
	}

	/*
	* 接收处理注册信息
	*/
	public function doUserRegister(Request $request)
	{
		if ($request->isMethod('post')){
			$arr = Input::post();
			$res = UserService::RegistrationVerification($arr);
			if (is_string($res)) {
				return redirect("/prompt")->with(['message'=>$res,'url' =>'/', 'jumpTime'=>3,'status'=>'error']);
;
			}else{
				if ($res) {
					return redirect("/prompt")->with(['message'=>'ok','url' =>'/', 'jumpTime'=>3,'status'=>'success']);
				}else{
					return redirect("/prompt")->with(['message'=>'ok','url' =>'/', 'jumpTime'=>3,'status'=>'error']);
				}
			}
        }else{
        	return 'Incorrect!';
        }
	}
	/*
	* 展示用户个人信息
	*/
	public function showUserInfo()
	{
		return view('user.self_info');
	}
}