<?php 

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use App\Services\IndexService;

class IndexController extends Controller
{
	/*
	* 展示首页
	*/
	public function showIndex()
	{
		$userinfo = IndexService::getSessionByCookie('userinfo');
		$sessionId = IndexService::getCookie('userinfo');
		//dump(IndexService::getCookie('userinfo'));
		$data = (array)$userinfo;
		//var_dump($data["\0*\0attributes"][$sessionId]);
		return view('index.index',['userinfo'=>$data["\0*\0attributes"][$sessionId]]);
	}

	/*
	* 用于测试
	*/
	public function test()
	{
		$service = new UserService();
		$res = $service->Rev(1.23);
		return $res;
	}
}