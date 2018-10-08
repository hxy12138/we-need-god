<?php 

namespace App\Services;

use Illuminate\Support\Facades\Validator;//////
use App\User;

class UserService
{
	/*
	* 注册验证
	*/ 
	static public function RegistrationVerification($arr)
	{
		$rules = ['captcha' => 'required|captcha'];
		$messages = [
			'cpt.required' => '请输入验证码',
 			'cpt.captcha' => '验证码错误，请重试'
		];
		$validator = Validator::make(['captcha'=>$arr['captcha']], $rules,$messages);
		if ($validator->fails()){
			return 'captcha error';
		}

		$data['u_name']='u_'.md5(time().rand(1,999999));
		if (isset($arr['tel'])) {
			if (empty($arr['tel'])) {
				return 'tel NULL';
			}
			$usermsg = '/^(13[0-9]|14[5|7]|15[0|1|2|3|5|6|7|8|9]|18[0|1|2|3|5|6|7|8|9])\d{8}$/';
			if (!preg_match($usermsg,$arr['tel'])) {
				return 'tel error!';
			}
			$data['u_tel']=$arr['tel'];
		}elseif(isset($arr['mail'])){
			if (empty($arr['mail'])) {
				return 'mail NULL';
			}
			$usermsg = '/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/';
			if (!preg_match($usermsg,$arr['mail'])) {
				return 'mail error!';
			}
			$data['u_mail']=$arr['mail'];
		}else{
			return '不得为空';
		}
		if($arr['password']==NULL){
			return 'password NULL';
		}else{
			$pattern="/^[\w-\.]{6,12}$/";
			if (!preg_match($pattern,$arr['password'])) {
				return 'password error';
			}elseif($arr['password']!=$arr['repassword']){
				return '两次密码不一致';
			}
			$data['u_pwd']=md5($arr['password']);
		}
		$data['u_addtime']=time();
		$res = User::InsertOneMsg($data);
		return $res;
	}

	/*
	*	判断登陆
	*/
	static public function LogonJudgement($arr)
	{
		$res = User::getUserOne($arr);
		if ($res) {
			$ip = self::getip();
			User::upLastLoginTime($res[0]->u_id,$ip,self::getCity($ip),self::loginAction());
		}
		return $res;
	}

    /*
    * 获取ip
    */
    static private function getip()
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
			$ip = "Unknown";
		}
		return $ip;
    }

    /*
    *获取地区
    */
    static private function getCity($ip = "Unknown")
	{
		if($ip == "Unknown"){
			$url = "http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=json";//新浪借口获取访问者地区
			$ip=json_decode(file_get_contents($url),true);
			$data = $ip;
		}else{
			$url="http://ip.taobao.com/service/getIpInfo.php?ip=".$ip;//淘宝借口需要填写ip
			$ip=json_decode(file_get_contents($url));
			if((string)$ip->code=='1'){
				return "Unknown";
			}
			$data = (array)$ip->data;
		}
		
		return $data;
	}

	/*
	* 登录方式 1:pc,2:小程序,3:手机
	*/
	static private function loginAction()
	{
		if (self::isMobile()) {
			return 3;
		}

		if (self::isWeixin()) {
			return 2;
		}

		return 1;
	}

	/*
	*判断是否是手机登录
	*/
	static private function isMobile() {
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
	* 判断是否是微信
	*/
	static private function isWeixin() {
		if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false) {
			return true;
		}
		
		return false;
	}

}