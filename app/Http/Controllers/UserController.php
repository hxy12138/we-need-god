<?php 

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class UserController extends Controller
{
	/*
	*展示用户登录页面
	*/ 
	public function showUserLogin()
	{
 		return view('user.login');
	}

	// 
	public function showUserRegister()
	{
		return view('user.register');
	}

	/*
	* 展示用户个人信息
	*/
	public function showUserInfo()
	{
		return view('user.self_info');
	}
}