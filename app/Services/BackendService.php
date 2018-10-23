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
			$id = $adminuser->lastInsertId();
			$adminUserRole = new AdminUserRole();
			if (isset($role)) {
				$result = [];
				foreach ($role as $k=>$v) {
					$result[$k]['admin_id'] = $id;
					$result[$k]['role_id'] = $v;
				}
				$adminUserRole->insertAll($result);
			}
			DB::commit();
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

	/**
	 * 查看用户是否有权限
	 */
	public function checkPower($path)
	{
		$arr = $this->getUserRoleResource();
		$menu = AdminRoleResource::getRoleMenu($arr);
		$button = AdminRoleResource::getRoleButton($arr);
		$result = false;
		for ($i=0; $i < count($menu); $i++) { 
			if ($menu[$i]['url']==$path) {
				$result = true;
				break;
			}
		}
		if (!$result) {
			for ($i=0; $i < count($menu); $i++) { 
				if ($menu[$i]['url']==$path) {
					$result = true;
					break;
				}
			}
		}
		
		return $result;
	}

	/**
	 * 获取所有资源
	 */
	public function getResource()
	{
		$data = $this->getAllMenu();
		$result = $this->makeCategoryTree($data);

		return $result;
	}

	/**
	 * 添加管理员
	 */
	public function addRole($arr)
	{
		array_shift($arr);
		if (isset($arr['resource'])) {
			$resource = $arr['resource'];
			unset($arr['resource']);
		}
		$flag = true;
		$adminrole = new AdminRole();
		DB::beginTransaction();
		try{
			$data = $adminrole->addRole($arr);
			$id = $adminrole->lastInsertId();
			$adminroleresource = new AdminRoleResource();
			if (isset($resource)) {
				$result = [];
				foreach ($resource as $k=>$v) {
					$result[$k]['role_id'] = $id;
					$result[$k]['resource_id'] = $v;
					$result[$k]['type'] = 1;
				}
				$adminroleresource->insertAll($result);
			}
			DB::commit();
		}catch(\Exception $e){
			$flag = false;
			DB::rollBack();
		}

		return $flag;
	}

	/**
	 * 获取所有权限
	 */
	public function getAllMenu()
	{
		$adminmenu = new AdminMenu();
		$data = $adminmenu->getAllMenu();
		array_multisort(array_column($data, 'path'), SORT_ASC, $data);

		return $data;
	}

	/**
	 * 获取父级权限
	 */
	public function getParentMenu()
	{
		$adminmenu = new AdminMenu();
		$data = $adminmenu->getParentMenu();

		return $data;
	}

	/**
	 * 添加
	 */
	public function addMenu($arr)
	{
		array_shift($arr);
		$adminmenu = new AdminMenu();
		$flag = true;
		DB::beginTransaction();
		try{
			$adminmenu->insertMenu($arr);
			$id = $adminmenu->lastInsertId();
			if ($arr['p_id'] != '0') {
				$str = $arr['p_id'].'-'.$id;
				$adminmenu->updatePath(['id'=>$id,'path'=>$str]);
			}else{
				$adminmenu->updatePath(['id'=>$id,'path'=>$id]);
			}
			DB::commit();
		}catch(\Exception $e){
			$flag = false;
			DB::rollBack();
		}

		return $flag;
	}

	/**
	 * 获取某个角色
	 */
	public function getOneRole($arr)
	{
		$adminrole = new AdminRole();
		$data = $adminrole->getOneRole($arr);

		return $data;
	}

	/**
	 * 获取某个角色的资源
	 */
	public function getOneRoleResource($arr)
	{
		$adminrole = new AdminRole();
		$data = $adminrole->getOneRoleResource($arr);

		return $data;
	}

	/**
	 * 修改某个角色的名称和资源
	 */
	public function updataRolePower($arr)
	{
		$userinfo = $this->getSession();
		if ($arr['role_name']==null||$userinfo['is_super']!=1) {
			return false;
		}

		array_shift($arr);
		$adminrole = new AdminRole();
		$adminroleresource = new AdminRoleResource();
		$flag = true;
		DB::beginTransaction();
		try{
			$adminrole->updataRole(['r_id'=>$arr['r_id'],'role_name'=>$arr['role_name']]);
			$adminroleresource->deleteSomeOne(['role_id'=>$arr['r_id']]);
			if (isset($arr['id'])) {
				$data = [];
				foreach ($arr['id'] as $k=>$v) {
					$data[$k]['resource_id'] = $v;
					$data[$k]['role_id'] = $arr['r_id'];
					$data[$k]['type'] = '1';
				}
				$adminroleresource->insertAll($data);
			}
			if (isset($arr['button_id'])) {
				$data = [];
				foreach ($arr['button_id'] as $k=>$v) {
					$data[$k]['resource_id'] = $v;
					$data[$k]['role_id'] = $arr['r_id'];
					$data[$k]['type'] = '0';
				}
				$adminroleresource->insertAll($data);
			}
			DB::commit();
		}catch(\Exception $e){
			$flag = false;
			DB::rollBack();
		}

		return $flag;
	}

	/**
	 * 删除角色
	 */
	public function deleteRolePower($id)
	{
        if ($id==1) {
            return false;
        }

		$adminrole = new AdminRole();
		$adminroleresource = new AdminRoleResource();
		$flag = true;
		DB::beginTransaction();
		try{
			$adminrole->deleteRole(['r_id'=>$id]);
			$adminroleresource->deleteSomeOne(['role_id'=>$id]);
			DB::commit();
		}catch(\Exception $e){
			$flag = false;
			DB::rollBack();
		}

		return $flag;
	}

	/**
	 * 通过id获取用户信息
	 */
	public function getUserById($id)
	{
		$adminuser = new AdminUser();
		$result = $adminuser->getUserOneForId($id);

		return $result;
	}

	/**
	 * 通过id获取用户角色
	 */
	public function getUserRoleById($id)
	{
		$adminuserrole = new AdminUserRole();
		$result = $adminuserrole->getAdminRole($id);

		return $result;
	}

	/**
	 * 修改管理员
	 */
	public function updataUser($arr)
	{
        if ($arr['id']==1) {
            return false;
        }
        if ($arr['password']==null) {
        	return false;
        }

		array_shift($arr);
		if (isset($arr['role'])) {
			$role = $arr['role'];
			unset($arr['role']);
		}
		$pwd = $this->getUserById($arr['id']);
		if ($pwd['password']==$arr['password']) {
			unset($arr['password']);
		}else{
			$arr['password'] = md5($arr['password']);
		}
		$arr['updated_at'] = time();

		$adminuser = new AdminUser();
		$adminuserrole = new AdminUserRole();
		$flag = true;
		DB::beginTransaction();
		try{
			$adminuser->updateUser($arr);
			if (isset($role)) {
				$adminuserrole->deleteSomeOne(['admin_id'=>$arr['id']]);
				$data = [];
				foreach ($role as $k=>$v) {
					$data[$k]['admin_id'] = $arr['id'];
					$data[$k]['role_id'] = $v;
				}
				$adminuserrole->insertAll($data);
			}
			DB::commit();
		}catch(\Exception $e){
			$flag = false;
			DB::rollBack();
		}

		return $flag;
	}

	/**
	 * 获取一条权限信息
	 */
	public function getOneMenu($id)
	{
		$adminmenu = new AdminMenu();

		return $adminmenu->getOneMenu(['id'=>$id]);
	}

	/**
	 * 修改权限
	 */
	public function updateMenu($arr)
	{
		array_shift($arr);

		if ($arr['p_id']==0) {
			$arr['path'] = $arr['id'];
		}else{
			$arr['path'] = $arr['p_id'].'-'.$arr['id'];
		}

		$adminmenu = new AdminMenu();

		return $adminmenu->updateMenu($arr);
	}

	/**
	 * 删除权限
	 */
	public function delMenu($id)
	{
        if ($id=='1') {
            return false;
        }

		$adminmenu = new AdminMenu();
		$adminroleresource = new AdminRoleResource();
		$flag = true;
		DB::beginTransaction();
		try{
			$adminmenu->delMenu(['id'=>$id]);
			$adminroleresource->deleteSomeOne(['resource_id'=>$id]);
			DB::commit();
		}catch(\Exception $e){
			$flag = false;
			DB::rollBack();
		}

		return $flag;
	}

	/**
	 * 假删除管理员
	 */
	public function delUser($id)
	{
        if ($id=='1') {
            return false;
        }
		$adminuser = new AdminUser();
		return $adminuser->delUser(['id'=>$id,'is_del'=>'1']);
	}
}