<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\ReceivedEmails;
use App\Http\Controllers\Controller;

class ReceivedEmailsController extends Controller
{

    public function store(Request $request)
    {

        $request->validate([
            'email' => 'required|max:255|unique:received_emails,email|regex:/[-0-9a-zA-Z.+_]+@[-0-9a-zA-Z.+_]+.[a-zA-Z]{2,4}/'
        ]);


        $insert = ReceivedEmails::create([
            'email' => $request->email
        ]);

        if ($insert->save()) {
            $request->session()->flash("success", "تم اضافة البيانات بنجاح");
            return back();
        }
    }

    public function destroy(Request $request)
    {
        $row = ReceivedEmails::find($request->id);
        if (!empty($row)) {
            // Delete Row From DB
            $row->delete();
            // Message
            $request->session()->flash('success', 'تم حذف البيانات بنجاح');
            return back();
        }
        return back();
    }


}
