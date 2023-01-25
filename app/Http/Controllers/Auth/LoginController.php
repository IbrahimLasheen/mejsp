<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{


    // Display Login Page For Admin
    public function index()
    {
        return view("main.auth.login");
    }


    public function login(Request $request)
    {

        $email = $request->email;
        $pass  = $request->password;

        if (Auth::guard("user")->attempt(["email" => $email, "password" => $pass], true)) {

            if (getAuth('user', 'status') == 0) {
                $request->session()->flash("auth_error_message", 'تم حظر هذا الحساب من المنصة');
                Auth::guard('user')->logout();
                return back();
            } else {
                return redirect(userPrefix() . "/dashboard");
            }

            return redirect(userPrefix() . "/dashboard");
        } else {

            $request->session()->flash("email", $email);
            $request->session()->flash("auth_error_message", 'خطأ في البريد الإلكتروني أو كلمة المرور');
            return back();
        }
    }
}
