<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AutoLogout
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {



        /***
         * AutoLogout For user
         */

        // Check If Have Auth user
        if (Auth::guard('user')->check()) {
            // Check If Status In active for redirect logout
            if (getAuth("user", "status") == 0) {
                Auth::guard('user')->logout();
            }
        }


        return $next($request);
    }
}
