<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{

    
    public function user_logout()
    {
        Auth::guard('user')->logout();

        return redirect("/login");
    }
}
