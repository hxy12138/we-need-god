<?php 

namespace App\Services;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cookie;
use Zhuzhichao\IpLocationZh\Ip;
use App\Models\AppUser;
// use BrowserDetect; //判断是啥客户端

class IndexService
{

	/**
	 * 获取cookie
	 */
	public static function getCookie($key)
	{
		return Cookie::get($key);
	}

	/**
	 * 获取session里的userinfo
	 */
	public static function getSessionByCookie($key)
	{
		// $userinfo = self::getCookie($key);
		return request()->session(request()->cookie($key));
	}
}