<?php 

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
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
			$result = UserService::logonJudgement($arr);
			if ($result==[]) {
				return redirect("/prompt")->with(['message'=>'登录失败！','url' =>'/login', 'jumpTime'=>5,'status'=>'error']);
			}
			if (is_string($result)) {
				return redirect("/prompt")->with(['message'=>$result,'url' =>'/login', 'jumpTime'=>5,'status'=>'error']);
			}
			UserService::saveUserLandingStatus($result[0]->u_id);
			return redirect("/prompt")->with(['message'=>'登录成功！','url' =>'/index', 'jumpTime'=>5,'status'=>'success']);
        }
        
        return 'Incorrect!';
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
			$result = UserService::registrVerification($arr);
			if (is_string($result)) {
				return redirect("/prompt")->with(['message'=>$result,'url' =>'/register', 'jumpTime'=>3,'status'=>'error']);
			}
			if ($result) {
				return redirect("/prompt")->with(['message'=>'ok','url' =>'/login', 'jumpTime'=>3,'status'=>'success']);
			}

			return redirect("/prompt")->with(['message'=>'失败','url' =>'/register', 'jumpTime'=>3,'status'=>'error']);
        }

        return 'Incorrect!';
	}

	/*
	* 展示用户个人信息
	*/
	public function showUserInfo()
	{
		return view('user.self_info');
	}
}