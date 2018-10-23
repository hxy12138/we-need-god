<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\BackendService;

class AdminController extends Controller
{
    /*
    * 后台展示
    */
    public function showIndex()
    {
        $BackendService = new BackendService();
        $userinfo = $BackendService->getSession();

        return view('admin.index',['userinfo' => $userinfo]);
    }

    /**
     * 展示菜单列表
     */
    public function showMenuList()
    {
        $BackendService = new BackendService();
        $userinfo = $BackendService->getSession();
        $menu = $BackendService->getAllMenu();

        return view('admin.menulist',['userinfo' => $userinfo,'menu'=>$menu]);
    }

    /**
     * 展示添加管理员页
     */
    public function showAddUser()
    {
        $BackendService = new BackendService();
        $userinfo = $BackendService->getSession();
        $role = $BackendService->getRole();

        return view('admin.addUser',['userinfo' => $userinfo,'role'=>$role]);
    }

    /**
     * 处理管理员添加
     */
    public function doAddUser(Request $request)
    {
        if ($request->isMethod('post')){
            $arr = Input::post();
            // dd($arr);
            $BackendService = new BackendService();
            $userinfo = $BackendService->addUser($arr);
            dd($userinfo);
            if ($userinfo) {
                return redirect("admin/userlist");
            }
            return redirect("admin/adduser");
        }
        
        return 'Incorrect!';
    }

    /**
     * 展示用户列表
     */
    public function showUserList()
    {
        $backendService = new BackendService();
        $userinfo = $backendService->getSession();
        $data = $backendService->getUserList();
        $button = $backendService->getButton();

        return view('admin.userlist',[
            'userinfo' => $userinfo,
            'data'=>$data,
            'button'=>$button,
        ]);
    }

    /**
     * 修改状态
     */
    public function userStatus(Request $request)
    {
        $backendService = new BackendService();
        $result = $backendService->chengStatus(Input::get());

        return redirect("admin/userlist");
    }

    /**
     * 展示角色列表
     */
    public function showRoleList()
    {
        $backendService = new BackendService();
        $userinfo = $backendService->getSession();
        $role = $backendService->getRole();

        return view('admin.rolelist',[
            'userinfo' => $userinfo,
            'role'=>$role
        ]);
    }

    /**
     * 展示添加角色页
     */
    public function showAddRole()
    {
        $backendService = new BackendService();
        $userinfo = $backendService->getSession();
        $resource = $backendService->getResource();

        return view('admin.addrole',['userinfo' => $userinfo,'resource'=>$resource]);
    }

    /**
     * 展示添加角色页
     */
    public function doAddRole(Request $request)
    {
        if ($request->isMethod('post')){
            $arr = Input::post();
            $BackendService = new BackendService();
            $result = $BackendService->addRole($arr);

            if ($result) {
                return redirect("admin/rolelist");
            }
            return redirect("admin/addrole");
        }
        
        return 'Incorrect!';
    }

    /**
     * 展示添加权限页
     */
    public function showAddMenu()
    {
        $backendService = new BackendService();
        $userinfo = $backendService->getSession();
        $parentmenu = $backendService->getParentMenu();

        return view('admin.addmenu',['userinfo' => $userinfo,'parentmenu'=>$parentmenu]);
    }

    /**
     * 展示添加角色页
     */
    public function doAddMenu(Request $request)
    {
        if ($request->isMethod('post')){
            $arr = Input::post();
            $BackendService = new BackendService();
            $result = $BackendService->addMenu($arr);

            if ($result) {
                return redirect("admin/menu");
            }
            return redirect("admin/addmenu");
        }
        
        return 'Incorrect!';
    }

    /**
     * 展示修改权限页
     */
    public function showUpdateMenu()
    {
        if (Input::get('id')==null) {
            return redirect("admin/userlist");
        }
        $id = Input::get('id');
        $backendService = new BackendService();
        $userinfo = $backendService->getSession();
        $parentmenu = $backendService->getParentMenu();
        $menu = $backendService->getOneMenu($id);

        return view('admin.updatemenu',[
            'userinfo' => $userinfo,
            'parentmenu'=>$parentmenu,
            'menu'=>$menu,
        ]);
    }

    /**
     * 处理修改
     */
    public function doUpdateMenu(Request $request)
    {
        if ($request->isMethod('post')){
            $arr = Input::post();
            $backendService = new BackendService();
            $result = $backendService->updateMenu($arr);

            if ($result) {
                return redirect("admin/menu");
            }
            return redirect("admin/updatemenu?id={$arr['id']}");
        }
        
        return 'Incorrect!';
    }

    /**
     * 处理删除权限
     */
    public function delMenu()
    {
        if (Input::get('id')==null) {
            return redirect("admin/userlist");
        }
        $id = Input::get('id');
        $backendService = new BackendService();
        $result = $backendService->delMenu($id);

        return redirect("admin/menu");
    }

    /**
     * 展示角色修改页面
     */
    public function showUpdataRolePower()
    {
        $backendService = new BackendService();
        $userinfo = $backendService->getSession();
        $menu = $backendService->getAllMenu();
        $button = $backendService->getButton();
        $role = $backendService->getOneRole(['r_id'=>Input::get('id')]);
        $data = $backendService->getOneRoleResource(['role_id'=>Input::get('id')]);

        return view('admin.addrolepower',[
            'userinfo' => $userinfo,
            'menu'=>$menu,
            'button'=>$button,
            'model'=>$data,
            'role'=>$role,
        ]);
    }

    /**
     * 处理角色修改
     */
    public function doUpdataRolePower(Request $request)
    {
        if ($request->isMethod('post')){
            $arr = Input::post();
            $BackendService = new BackendService();
            $result = $BackendService->updataRolePower($arr);

            if ($result) {
                return redirect("admin/rolelist");
            }
            return redirect("admin/updatarolepower?id={$arr['r_id']}");
        }
        
        return 'Incorrect!';
    }

    /**
     * 处理角色删除
     */
    public function deleteRolePower()
    {
        $id = Input::get('id');
        $BackendService = new BackendService();
        $BackendService->deleteRolePower($id);

        return redirect("admin/rolelist");
    }

    /**
     * 展示管理员修改页面
     */
    public function showUpdateUser()
    {
        if (Input::get('id')==null) {
            return redirect("admin/userlist");
        }
        $id = Input::get('id');
        $BackendService = new BackendService();
        $userinfo = $BackendService->getSession();
        $role = $BackendService->getRole();
        $data = $BackendService->getUserById($id);
        $userrole = $BackendService->getUserRoleById($id);

        return view('admin.updateuser',[
            'userinfo' => $userinfo,
            'role'=>$role,
            'data'=>$data,
            'userrole'=>$userrole,
        ]);
    }

    /**
     * 处理管理员修改
     */
    public function doUpdateUser(Request $request)
    {
        if ($request->isMethod('post')){
            $arr = Input::post();
            // dd($arr);
            $BackendService = new BackendService();
            $result = $BackendService->updataUser($arr);

            if ($result) {
                return redirect("admin/userlist");
            }
            return redirect("admin/updateuser?id={$arr['id']}");
        }
        
        return 'Incorrect!';
    }
    
    /**
     * 管理员删除
     */
    public function delUser()
    {
        if (Input::get('id')==null) {
            return redirect("admin/userlist");
        }
        $id = Input::get('id');
        $BackendService = new BackendService();
        $result = $BackendService->delUser($id);

        return redirect("admin/userlist");
    }
}
