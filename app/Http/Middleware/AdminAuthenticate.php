<?php

namespace App\Http\Middleware;

use Closure;
use App\Model\Admin\AdminModel;

class AdminAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (!app('session')->has('admin_id')) {
            if($request->ajax()){
                return response()->json(array(
                    'status'=>-2,
                    'message'=>'您还没有登录！',
                ));
            }else{
                return redirect('admin/login');
            }
            
        }

        $admin = new AdminModel();
        $session_id = $admin->where('id',app('session')->get('admin_id')['id'])->first()->session_id;
        if ($session_id != app('session')->getId()) {
            if($request->ajax()){
                return response()->json(array(
                    'status'=>-2,
                    'message'=>'您还没有登录！',
                ));
            }else{
                return redirect('admin/login');
            }
            
        }


        return $next($request);
    }
}
