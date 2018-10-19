<?php

namespace App\Http\Middleware;

use Closure;

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
        $userinfo = (array)request()->session(request()->cookie('admin_userinfo'));
        if (isset($userinfo["\0*\0attributes"][request()->cookie('admin_userinfo')])) {
            return $next($request);
        }else{
            return redirect("admin/login");
        }
    }
}
