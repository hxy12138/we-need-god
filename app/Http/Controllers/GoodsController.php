<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GoodsController extends Controller
{
    /*
    * 商品列表展示
    */
    public function showGoodsList()
    {
		return view('goods.goodsList');
    }

    /*
    * 商品详情展示
    */
    public function showGoodsDetails()
    {
		return view('goods.details');
    }
}
