<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//5255
// 小米模版
 Route::get('/testplus','IndexController@test');
 Route::get('/', 'IndexController@showIndex');
 Route::get('/index', 'IndexController@showIndex');
 Route::get('/login', 'UserController@showUserLogin');
 Route::get('/loginout', 'UserController@userLoginOut');
 Route::post('/dologin', 'UserController@doUserLogin');
 Route::get('/self_info', 'UserController@showUserInfo');
 Route::get('/register', 'UserController@showUserRegister');
 Route::post('/doregister', 'UserController@doUserRegister');
 Route::get('/goodsList', 'GoodsController@showGoodsList');
 Route::get('/details', 'GoodsController@showGoodsDetails');
 Route::get('/orderCenter', 'OrderController@showOrderCenter');
 Route::get('/carte', 'CarteController@showCarte');

 Route::any('/prompt','PromptController@index');