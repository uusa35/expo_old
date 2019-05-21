<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class IsUser
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
        if (Auth::user() && Auth::user()->admin != 0 ) {
            abort(403);
        }
        if(Auth::user()->user_type!=1){
            abort(403);
        }
        return $next($request);
    }

}
