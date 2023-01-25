<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserAuth
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

    if (!Auth::guard('user')->check()) { // IF Not Have User Login Redirect To Login Page
      return redirect("/login");
    }

    return $next($request);
  }
}
