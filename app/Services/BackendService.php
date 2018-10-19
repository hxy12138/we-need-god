<?php 

namespace App\Services;

use App\Models\AdminUser;
use App\Models\AdminUserRole;
use App\Models\AdminRole;
use App\Models\AdminRoleResource;
use App\Models\AdminMenu;
use Illuminate\Support\Facades\Cookie;
use DB;

/**
 * 
 */
class BackendService
{

	/*
	*	判断登陆
	*/
	public function logonJudgement($arr)
	{
        $data[':password'] = md5($arr['password']);
        $data[':username'] = $arr['email'];
		$adminuser = new AdminUser();
		$result = $adminuser->getUserOneForLogin($data);
		return $result;
	}

	/**
	 * 保存登陆状态
	 */
	public function saveUserLandingStatus($userinfo)
	{
		$key = md5(time().rand(1,99999).rand(1,99999));
		$data = [
			'id'=>$userinfo['userinfo'][0]->id,
			'username'=>$userinfo['userinfo'][0]->username,
			'name'=>$userinfo['userinfo'][0]->name,
			'is_super'=>$userinfo['userinfo'][0]->is_super,
			'created_at'=>$userinfo['userinfo'][0]->created_at,
			'updated_at'=>$userinfo['userinfo'][0]->updated_at,
		];
		session([$key=>$data]);
		if ($userinfo['remember']) {
			Cookie::queue('admin_userinfo',$key,86400);
		}else{
			Cookie::queue('admin_userinfo',$key,3600);
		}
		return response('token', 200)->header('Content-Type', 'text/plain');
	}

	/**
	 * 获取角色资源
	 */
	public function getUserRole()
	{
		$arr = $this->getUserRoleResource();
		$result = AdminRoleResource::getRoleMenu($arr);
		$data = $this->makeCategoryTree($result);
		array_unshift($data, '后台');
		return $data;
	}

	/**
	 * 获取资源
	 */
	public function getUserRoleResource()
	{
		$userinfo = $this->getSession();
		$data = AdminUserRole::getAdminRole($userinfo['id']);
		$arr = [];
		foreach ($data as $k => $v) {
			$arr[] = $v['role_id'];
		}
		return $arr;
	}

	/**
	 * 获取按钮
	 */
	public function getButton()
	{
		$arr = $this->getUserRoleResource();
		$result = AdminRoleResource::getRoleButton($arr);
		return $result;
	}

	/**
	 * 获取session信息
	 */
	public function getSession()
	{
		$userinfo = (array)request()->session(request()->cookie('admin_userinfo'));
		if (isset($userinfo["\0*\0attributes"][request()->cookie('admin_userinfo')])) {
			$data = $userinfo["\0*\0attributes"][request()->cookie('admin_userinfo')];
		}else{
			$data = NULL;
		}
		return $data;
	}

	/**
	 * 无限极分类
	 */
	public function makeCategoryTree($data,$pid=0)
	{
		$arr=[];
		foreach($data as $k => $v){
			if ($v['p_id'] === $pid) {
				$arr[$k] = $v;
				$arr[$k]['submenu'] = $this->makeCategoryTree($data,$v['id']);
			}
		}
		return $arr;
	}

	/**
	 * 删除登陆状态
	 */
	public function delUserLandingStatus()
	{
		
		Cookie::queue('admin_userinfo',NULL,-1);
		
		return response('token', 200)->header('Content-Type', 'text/plain');
	}

	/**
	 * 获取管理员列表
	 */
	public function getUserList()
	{
		$adminuser = new AdminUser();
		$data =$adminuser->getUser();
		return $data;
	}

	/**
	 * 获取角色列表
	 */
	public function getRole()
	{
		$adminrole = new AdminRole();
		$data = $adminrole->getRole();
		return $data;
	}

	/**
	 * 添加管理员
	 */
	public function addUser($arr)
	{
		array_shift($arr);
		$arr['created_at'] = time();
		$arr['password'] = md5($arr['password']);
		if (isset($arr['role'])) {
			$role = $arr['role'];
			unset($arr['role']);
		}
		$flag = true;
		$adminuser = new AdminUser();
		DB::beginTransaction();
		try{
			$data = $adminuser->addUser($arr);
			$id = $adminuser->insertID();
			$adminUserRole = new AdminUserRole();
				$result = [];
				foreach ($role as $k=>$v) {
					$result[$k]['admin_id'] = $id;
					$result[$k]['role_id'] = $v;
				}
			$adminUserRole->insertAll($result);
		}catch(\Exception $e){
			$flag = false;
			DB::rollBack();
		}
		return $flag;
	}

	/**
	 * 修改用户状态
	 */
	public function chengStatus($arr)
	{
        $arr['status'] = ($arr['status']=='1')?'0':'1';
		$adminuser = new AdminUser();
		$result = $adminuser->chengStatus($arr);
		return $result;
	}
}