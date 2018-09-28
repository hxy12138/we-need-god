<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    /*
    *订单中心展示
    */
    public function showOrderCenter()
    {
    	return view('order.orderCenter');
    }
}
