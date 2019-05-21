<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\PaymentProcess;
use App\Models\Setting;
use Carbon\Carbon;

class Customer
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
        if (Auth::user() && Auth::user()->admin != 1 ) {
            abort(403);
        }
        if(Auth::user()->user_type!=2){
            abort(403);
        }
     
        return $next($request);
    }

}
