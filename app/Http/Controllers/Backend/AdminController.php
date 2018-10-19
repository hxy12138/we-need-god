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
        // $userinfo = $BackendService->getSession();
        // if (!$userinfo) {
        //     return redirect("admin/login");
        // }
        $userinfo = $BackendService->getSession();
        return view('admin.index',['userinfo' => $userinfo]);
        // return view('admin.index');
    }

    /**
     * 展示菜单列表
     */
    public function showMenuList()
    {
        $BackendService = new BackendService();
        $userinfo = $BackendService->getSession();
        return view('admin.menulist',['userinfo' => $userinfo]);
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
        $BackendService = new BackendService();
        $userinfo = $BackendService->getSession();
        $data = $BackendService->getUserList();
        $button = $BackendService->getButton();
        dump($userinfo);
        dump($data);
        dump($button);
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
        $BackendService = new BackendService();
        $result = $BackendService->chengStatus(Input::get());
        return redirect("admin/userlist");
    }
}
