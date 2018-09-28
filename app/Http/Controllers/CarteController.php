<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CarteController extends Controller
{
    /*
    * 购物车展示
    */
    public function showCarte()
    {
    	return view('carte.carte');
    }
}
