<?php

namespace App\Http\Middleware;

use Closure,App\User;

class AppAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function handle($request, Closure $next, $guard = null)
    {
        if (!app('session')->has('user_id') || !$this->user->findUserById(app('session')->get('user_id'))) {
            if($request->ajax()){
                return response()->json(array(
                    'status'=>-1,
                    'msg'=>'您还没有登录！',
                ));
            }else{
                return redirect('app/auth/login?refer='.urlencode($request->path()));
            }
        }

        return $next($request);
    }
}
