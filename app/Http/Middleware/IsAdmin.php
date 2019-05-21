<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::user() && Auth::user()->admin != 1) {
            if(Auth::user()->user_type!=1){
              //  dd(Auth::user());
                return redirect('/admin/myProfile');
            }else{
                return redirect('/user/profile');
            }
        }
        
        return $next($request);
    }

}
