<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

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
	* 用户注册展示
	*/ 
	public function showUserRegister()
	{
		return view('user.register');
	}

	/*
	* 接收注册信息
	*/
	public function doUserRegister()
	{
		dd(input::post());
		$stat = input::post('mail');
		if ($stat==NULL) {
			$tel = input::post('tel');
		}else{
			
		}
			$password = input::post('password');
			$repassword = input::post('repassword');
	}
	/*
	* 展示用户个人信息
	*/
	public function showUserInfo()
	{
		return view('user.self_info');
	}
}