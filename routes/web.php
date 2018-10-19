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
// 小米商城
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

 // 后台

Route::get('/admin/login', 'BackendLoginController@showLogin');
Route::post('/admin/logindo', 'BackendLoginController@loginDo');

Route::middleware(['AdminLogin'])->group(function(){
	Route::get('/admin/home', 'Backend\AdminController@showIndex');
	Route::get('/admin/menu', 'Backend\AdminController@showMenuList');
	Route::get('/admin/userlist', 'Backend\AdminController@showUserList');
	Route::post('/admin/loginout', 'BackendLoginController@adminLoginout');
	Route::post('/admin/adduserdo', 'Backend\AdminController@doAddUser');
	Route::get('/admin/adduser', 'Backend\AdminController@showAddUser');
	Route::get('/admin/userstatus', 'Backend\AdminController@userStatus');
});