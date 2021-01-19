<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
session_start();
class AcessPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,...$roles)
    {


         foreach ($roles as $role) {
            try {
                // foreach($quyenuser as $k=>$q)
                // {
                    if (Auth::user()->getrole($role)) {
                        Session::put("message_per","");
                        return $next($request);
                //}

            }

            } catch (Exception $x) {
                abort(403);
            }
        }
        Session::put("message_per","Bạn không có quyền vào trang này");
        return redirect('/dashboard');
    }

}
