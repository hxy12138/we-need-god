<?php 

namespace App\Services;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Http\Request;
use App\Models\AppUser;
use App\Jobs\SendEmail;
use App\Models\AppLoginLog;
use Zhuzhichao\IpLocationZh\Ip;
//use DispatchesJobs;
// use BrowserDetect; //判断是啥客户端

class UserService
{

	/*
	* 注册验证
	*/ 
	public static function registrVerification($arr)
	{
		$rules = [
			'captcha' => 'required|captcha',
			'tel' => [
						'required_without:mail',
						'unique:app_user,u_tel',
						'regex:/^(13[0-9]|14[5|7]|15[0|1|2|3|5|6|7|8|9]|18[0|1|2|3|5|6|7|8|9])\d{8}$/'
					],
			'mail' => 'required_without:tel|email|unique:app_user,u_mail',
			'password' => 'required|between:6,12',
			'repassword' => 'required|same:password',
		];
		$messages = [
			'captcha.required' => '请输入验证码',
 			'captcha.captcha' => '验证码错误，请重试',
 			'tel' =>[
				'required_without' => '请输入手机号',
				'regex' => '请输入正确手机号',
			],
			'tel.unique' => '此手机号已被注册',
			'mail'=>[
				'required_without' => '邮箱不得为空',
				'email' => '请输入正确邮箱',
			],
			'mail.unique' => '此邮箱已被注册',
 			'password.required' => '密码不得为空',
 			'password.between' => '密码请输入6位以上12位以下字符',
 			'repassword.required' => '确认密码不得为空',
 			'repassword.same' => '两次密码不一致',
		];
		$validator = Validator::make($arr, $rules,$messages);
		$data['u_name']='u_'.date('m_d_i_s',time()).rand(1,99);
		if ($validator->fails()){
			$errors = $validator->errors();
			if ($errors->has('captcha')) {
				return $errors->first('captcha');
			}
			if (isset($arr['tel'])&&$errors->has('tel')) {
				return $errors->first('tel');
			}
			if (isset($arr['mail'])&&$errors->has('mail')) {
				return $errors->first('mail');
			}
			if ($errors->has('password')) {
				return $errors->first('password');
			}
			if ($errors->has('repassword')) {
				return $errors->first('repassword');
			}
			return json_encode($errors->all());
		}
		$data['u_tel'] = isset($arr['tel'])?$arr['tel']:NULL;
		$data['u_mail'] = isset($arr['mail'])?$arr['mail']:NULL;
		$data['u_pwd'] = md5($arr['password']);
		$data['u_addtime'] = time();
		$result = AppUser::add($data);
		if ($result) {
			if (isset($arr['mail'])) {
				self::sendEmail($arr['mail'],'橘猫欢迎您注册');
			}
			self::saveUserLandingStatus(AppUser::getLastInsertId());
		}
		return $result;
	}

	/*
	*	判断登陆
	*/
	public static function logonJudgement($arr)
	{
		$rules = ['captcha' => 'required|captcha'];
		$messages = [
			'captcha.required' => '请输入验证码',
 			'captcha.captcha' => '验证码错误，请重试'
 		];
 		$validator = Validator::make(['captcha'=>$arr['captcha']], $rules,$messages);
 		if ($validator->fails()){
			$errors = $validator->errors();
			return $errors->all();
			if ($errors->has('captcha')) {
				return $errors->first('captcha');
			}
		}
		$result = AppUser::getUserOneForLogin($arr);
		if ($result) {
			$ip = self::getIp();
			$id = $result[0]->u_id;
			AppUser::upLastLoginTime($id);
			$getcity = self::getCity($ip);
			AppLoginLog::add([
				'u_id' => $result[0]->u_id,
				'login_time' => time(),
				'login_ip' => $ip,
				'login_address' => "{$getcity[0]} {$getcity[1]} {$getcity[2]}",
				'login_action' => self::loginAction()
			]);
			$data = AppLoginLog::getDataAce($id);
			if (count($data)>10) {
				AppLoginLog::deleteOne($data[0]->l_id);
			}
		}
		return $result;
	}

	/**
	 * 保存登陆状态
	 */
	public static function saveUserLandingStatus($userid)
	{
		$key = md5(time().rand(1,99999).rand(1,99999));
		$userinfo = AppUser::getUserInfo($userid);
		//dd($userinfo);
		session([$key=>$userinfo]);
		Cookie::queue('userinfo',$key,86400);
		return response('token', 200)->header('Content-Type', 'text/plain');
	}

	/**
	 * 删除登陆状态
	 */
	public static function delUserLandingStatus()
	{
		
		Cookie::queue('userinfo',NULL,-1);
		
		return response('token', 200)->header('Content-Type', 'text/plain');
	}

	/**
	 * 发送邮件
	 */
	public static function sendEmail($email,$message)
	{
		$sendEmail = new SendEmail(['email'=>$email,'message'=>$message]);
		dispatch($sendEmail);
	}

    /*
    * 获取ip
    */
    private static function getIp()
    {
    	if (isset($_SERVER["HTTP_X_FORWARDED_FOR"]))
		{
			$ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
		}
		elseif (isset($_SERVER["HTTP_CLIENT_IP"]))
		{
			$ip = $_SERVER["HTTP_CLIENT_IP"];
		}
		elseif (isset($_SERVER["REMOTE_ADDR"]))
		{
			$ip = $_SERVER["REMOTE_ADDR"];
		}
		elseif (getenv("HTTP_X_FORWARDED_FOR"))
		{
			$ip = getenv("HTTP_X_FORWARDED_FOR");
		}
		elseif (getenv("HTTP_CLIENT_IP"))
		{
			$ip = getenv("HTTP_CLIENT_IP");
		}
		elseif (getenv("REMOTE_ADDR"))
		{
			$ip = getenv("REMOTE_ADDR");
		}
		else
		{
			$ip = 'Unknown';
		}
		return $ip;
    }

    /*
    *获取地区
    */
    private static function getCity($ip = 'Unknown')
	{
		if ($ip == 'Unknown') {
			return 'Unknown';
		}
		return Ip::find($ip);
	}

	/** 
	* 登录方式
	*/
	private static function loginAction()
	{
		if (self::isMobile()) {
			return 'mobile';
		}

		if (self::isWeixin()) {
			return 'weixin';
		}

		return 'pc';
	}

	/*
	*判断是否是手机登录
	*/
	private static function isMobile()
	{
		// 如果有HTTP_X_WAP_PROFILE则一定是移动设备
		if (isset($_SERVER['HTTP_X_WAP_PROFILE'])) {
			return true;
		}
		// 如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
		if (isset($_SERVER['HTTP_VIA'])) {
			// 找不到为flase,否则为true
			return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
		}
		// 脑残法，判断手机发送的客户端标志,兼容性有待提高。其中'MicroMessenger'是电脑微信
		if (isset($_SERVER['HTTP_USER_AGENT'])) {
			$clientkeywords = array('nokia','sony','ericsson','mot','samsung','htc','sgh','lg','sharp','sie-','philips','panasonic','alcatel','lenovo','iphone','ipod','blackberry','meizu','android','netfront','symbian','ucweb','windowsce','palm','operamini','operamobi','openwave','nexusone','cldc','midp','wap','mobile','MicroMessenger');
	    	// 从HTTP_USER_AGENT中查找手机浏览器的关键字
	    	if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT']))) {
	    		return true;
	    	}
		}
		// 协议法，因为有可能不准确，放到最后判断
		if (isset ($_SERVER['HTTP_ACCEPT'])) {
			// 如果只支持wml并且不支持html那一定是移动设备
	    	// 如果支持wml和html但是wml在html之前则是移动设备
			if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html')))) {
				return true;
			}
		}
		return false;
	}

	/*
	* 判断是否是微信自带浏览器
	*/
	private static function isWeixin()
	{
		if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false) {
			return true;
		}
		
		return false;
	}

}