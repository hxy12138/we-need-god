<?php

namespace App\Http\Middleware;

use Closure;
use App\Services\BackendService;

class AdminLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // return $next($request);
        // 判断是否登录
        $userinfo = (array)request()->session(request()->cookie('admin_userinfo'));
        if (!isset($userinfo["\0*\0attributes"][request()->cookie('admin_userinfo')])) {
            return redirect("admin/login");
        }
        // 判断是否是超级管理员
        if ($userinfo["\0*\0attributes"][request()->cookie('admin_userinfo')]['is_super']==1) {
            return $next($request);
        }
        // 判断是否是访问主页面和退出登录
        if ($request->path()=='admin/home'||$request->path()=='admin/loginout') {
            return $next($request);
        }
        // 判断是否有权限访问
        $backendService = new BackendService();
        if (!$backendService->checkPower($request->path())) {
            return redirect("admin/home");
        }
        return $next($request);
    }
}
