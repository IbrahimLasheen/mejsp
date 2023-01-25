<?php

namespace App\Http\Controllers\Auth;

use App\Models\Users;
use App\Mail\ResetMail;
use App\Mail\UserResetMail;
use App\Models\Freelancers;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class ForgetController extends Controller
{
    public function forget()
    {
        return view("main.auth.forget");
    }

    public function send_mail(Request $request)
    {
        $request->validate(['email' => 'required|regex:/[-0-9a-zA-Z.+_]+@[-0-9a-zA-Z.+_]+.[a-zA-Z]{2,4}/',]);
        $email = $request->email;
        $fetchRow = User::select('email', 'verified_code', 'id')->where("email", $email)->first();
        if(!$fetchRow){
             $request->session()->flash("error", 'هذا البريد غير موجود رجاء التاكد مرة اخري');
            return back();
        }
        $email = $fetchRow->email;
        $row_for_update = User::find($fetchRow->id);
        $code = $row_for_update->verified_code = rand(100000, 900000);
        $row_for_update->save();
        if (!empty($email)) {
            $info = ["link" => url("reset-password/" . Crypt::encryptString($email)), 'code' => $code];
            Mail::to($email)->send(new ResetMail($info));
            $request->session()->flash("message", 'سيصلك بريد علي حسابك خلال ثوان');
            return back();
        } else {
            $request->session()->flash("error", 'هذا البريد غير موجود رجاء التاكد مرة اخري');
            return back();
        }
    }
    public function reset()
    {
        return view("main.auth.reset");
    }

    public function update_password(Request $request, $email_hash)
    {
        $request->validate(['email' => 'required|regex:/[-0-9a-zA-Z.+_]+@[-0-9a-zA-Z.+_]+.[a-zA-Z]{2,4}/', 'password' => 'required|min:6|max:255', 'code' => 'required']);
        try {
            $email = $request->email;
            $password = $request->password;
            $code = $request->code;
            $decrypt = Crypt::decryptString($email_hash);
            $getRowFromDB = User::select("email", 'verified_code', 'id')->where("email", $email)->get();
            $id = $getRowFromDB->pluck('id');
            $verified_code = $getRowFromDB->pluck('verified_code')[0];
            $row = User::find($id[0]);
            if ($decrypt == $email) {

                if ($verified_code == $code) {
                    $row->password = Hash::make($password);
                    $row->verified_code = NULL;
                    if ($row->save()) {
                        return redirect('login');
                    }
                } else {
                    $request->session()->flash("error", 'يرجي التحقق من الكود المرفق في البريد');
                    return back();
                }
            } else {
                $request->session()->flash("error", 'خطأ يرجي التحقق من البريد واعادة المحاولة');
                return back();
            }
        } catch (DecryptException $e) {
            $request->session()->flash("error", 'خطأ في تحديث البيانات حاول مرة اخري');
            return back();
        }
    }


}
