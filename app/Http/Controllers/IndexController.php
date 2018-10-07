<?php 

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\UserService;

class IndexController extends Controller
{
	/*
	* 展示首页
	*/
	public function showIndex()
	{
		return view('index.index');
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