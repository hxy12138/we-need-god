<?php 

namespace App\Services;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cookie;
use Zhuzhichao\IpLocationZh\Ip;
use App\Models\AppUser;
use App\Models\AppCategory;
use App\Models\AppGoods;
// use BrowserDetect; //判断是啥客户端

class IndexService
{

	/**
	 * 获取cookie
	 */
	public static function getCookie($key)
	{
		return request()->cookie($key);
	}

	/**
	 * 获取session里的userinfo
	 */
	public static function getSessionByCookie($key)
	{
		$userinfo = (array)request()->session(request()->cookie($key));
		if (isset($userinfo["\0*\0attributes"][request()->cookie($key)])) {
			$data = $userinfo;
		}else{
			$data = NULL;
		}
		return $data;
	}

	/**
	 * 获取商品数据
	 */
	public static function getCategory()
	{
		$appCategory = new AppCategory;
		$data = $appCategory->getCategory();
		$result = self::makeCategoryTree($data);
		return $result;
	}

	/**
	 * 无限极分类
	 */
	public static function makeCategoryTree($data,$pid=0)
	{
		$arr=[];
		foreach($data as $k => $v){
			if ($v['p_id'] == $pid) {
				$arr[$k] = $v;
				$arr[$k]['son'] = self::makeCategoryTree($data,$v['cat_id']);
			}
		}
		return $arr;
	}
}