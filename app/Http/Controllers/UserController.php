<?php 

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\UserService;
use App\Jobs\SendEmail;

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
			// $ss = UserService::logonJudgement($arr);
			// dd($ss);
			if (!(UserService::logonJudgement($arr)==[])) {
				return redirect("/prompt")->with(['message'=>'登录成功！','url' =>'/', 'jumpTime'=>5,'status'=>'success']);
			}
			
			return redirect("/prompt")->with(['message'=>'登录失败！','url' =>'/login', 'jumpTime'=>5,'status'=>'error']);
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
				if (isset($arr['mail'])) {
					$this->queueSendEmail($arr['mail']);
				}
				return redirect("/prompt")->with(['message'=>'ok','url' =>'/', 'jumpTime'=>3,'status'=>'success']);
			}

			return redirect("/prompt")->with(['message'=>'失败','url' =>'/register', 'jumpTime'=>3,'status'=>'error']);
        }

        return 'Incorrect!';
	}

	/**
	 * 队列发送邮件
	 */
	public function queueSendEmail($email)
	{
		$this->dispatch(new SendEmail($email));
	}

	/*
	* 展示用户个人信息
	*/
	public function showUserInfo()
	{
		return view('user.self_info');
	}
}