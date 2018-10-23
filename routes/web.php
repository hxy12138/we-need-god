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

/**
 * 走中间件判断是否登录是否有权限
 */
Route::middleware(['AdminLogin'])->group(function(){
	Route::get('/admin', 'Backend\AdminController@showIndex');
	Route::get('/admin/home', 'Backend\AdminController@showIndex');
	Route::post('/admin/loginout', 'BackendLoginController@adminLoginout');

	//权限管理
	Route::get('/admin/menu', 'Backend\AdminController@showMenuList');//展示权限列表
	Route::get('/admin/addmenu', 'Backend\AdminController@showAddMenu');//展示添加权限页
	Route::post('/admin/addmenudo', 'Backend\AdminController@doAddMenu');//处理添加权限
	Route::get('/admin/updatemenu', 'Backend\AdminController@showUpdateMenu');//展示修改权限页
	Route::post('/admin/updatemenudo', 'Backend\AdminController@doUpdateMenu');//处理修改权限
	Route::get('/admin/delmenu', 'Backend\AdminController@delMenu');//删除权限
	
	//用户管理
	Route::get('/admin/userlist', 'Backend\AdminController@showUserList');//展示管理员列表
	Route::get('/admin/userstatus', 'Backend\AdminController@userStatus');//处理管理员冻结、解冻
	Route::post('/admin/adduserdo', 'Backend\AdminController@doAddUser');//展示添加管理员
	Route::get('/admin/adduser', 'Backend\AdminController@showAddUser');//处理添加管理员
	Route::get('/admin/updateuser', 'Backend\AdminController@showUpdateUser');//展示修改管理员
	Route::post('/admin/updateuserdo', 'Backend\AdminController@doUpdateUser');//处理修改管理员
	Route::get('/admin/deluser', 'Backend\AdminController@delUser');//删除管理员

	//角色管理
	Route::get('/admin/addrole', 'Backend\AdminController@showAddRole');//展示添加角色页
	Route::post('/admin/addroledo', 'Backend\AdminController@doAddRole');//处理添加角色
	Route::get('/admin/updatarolepower', 'Backend\AdminController@showUpdataRolePower');//展示修改角色页
	Route::post('/admin/roleupdatedo', 'Backend\AdminController@doUpdataRolePower');//处理修改角色
	Route::get('/admin/deletrolepower', 'Backend\AdminController@deleteRolePower');//处理角色删除
	Route::get('/admin/rolelist', 'Backend\AdminController@showRoleList');//展示角色列表
});