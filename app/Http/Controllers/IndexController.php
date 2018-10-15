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
		$category = IndexService::getCategory();
		return view('index.index',['userinfo'=>$userinfo,'category'=>$category]);
	}
}