<?php

namespace App\Http\Middleware;

use Closure;

class SuperAdminAuthenticate
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
        if (app('session')->get('admin_id')['status']===0) {
            if($request->ajax()){
                return response()->json(array(
                    'status'=>-3,
                    'message'=>'您没有权限操作！',
                ));
            }else{
                return redirect('admin/knowledge');
            }
            
        }

        return $next($request);
    }
}
