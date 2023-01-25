<?php namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\InternationalTypes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Models\InternationalJournals;
use App\Models\InternationalSpecialties;
use App\Models\InternationalPublicationOrders;
use App\Mail\NotificationsInternationalPublishingMail;
use App\Models\Admin\Admins;
use App\Notifications\InternationalRequest;
use App\Notifications\RecivedOrder;
use Notification;

class InternationalPublicationOrdersController extends Controller
{
    const PATH = "assets/uploads/international-publication-orders/";

    public function orders()
    {
        $rows = InternationalPublicationOrders::with(['journal' => function ($q) {
            $q->select("id", 'name', 'price');
        }, "user"])->orderBy('id', 'DESC')->get();
        return view("admin.international-publication.orders", compact('rows'));
    }

    public function show($id)
    {
        $intr = InternationalPublicationOrders::with(['journal' => function ($q) {
            $q->select("id", 'name', 'price');
        }, "user"])->where("id", $id)->first();
        if (!empty($intr)) {
            $pay = Payment::where('for_international_publishing', $id)->first();
            return view("admin.international-publication.show", compact("intr", "pay"));
        } else {
            return redirect(adminUrl("international-publishing/orders"));
        }
    }

    public function index()
    {
        $pageTitle = 'طلبات النشر الدولي';
        $rows = InternationalPublicationOrders::with(['journal'])->where("user_id", getAuth('user', 'id'))->orderBy('id', 'DESC')->get();
        return view("main.user.international-publishing.all", compact('pageTitle', 'rows'));
    }

    public function create()
    {
        $pageTitle = 'طلب نشر دولي جديد';
        $types = InternationalTypes::orderBy("id", 'DESC')->get();
        return view("main.user.international-publishing.create", compact('pageTitle', 'types'));
    }

    public function admin_destroy(Request $request)
    {
        $row = InternationalPublicationOrders::find($request->id);
        if (!empty($row)) {
            @unlink(self::PATH . $row->file);
            $row->delete();
        }
        return back();
    }

    public function store(Request $request)
    {
        $journals_all_id = DB::table('international_journals')->select('id')->get();
        $jourIDs = [];
        foreach ($journals_all_id as $jour_id) {
            array_push($jourIDs, $jour_id->id);
        }
        $request->validate(['type' => 'required', 'specialty' => "required", 'journal' => "required|in:" . implode(",", $jourIDs), 'file' => 'required|mimes:docx,doc', 'desc' => 'nullable|max:3000',]);
        $fileName = randomName() . '.' . $request->file->extension();
        $insert = InternationalPublicationOrders::create(['journal_id' => $request->journal, 'file' => $fileName, 'desc' => $request->desc, 'user_id' => getAuth('user', 'id'),]);

        if ($insert->save()) {

            $admins = Admins::all();
            foreach ($admins as $admin) {

            $requestData = [
                'id' => $insert->id,
                'user_id' => getAuth('user', 'id'),
                'user_name' => getAuth('user', 'name'),
                'type' => 'post',
                'body' => ' لديك  طلب نشر دولي جديد',
            ];
            Notification::send($admin, new InternationalRequest($requestData));
            
        }

            upload($request->file, self::PATH, $fileName);
            $jourRow = DB::table('international_journals')->select("name", 'price')->where("id", $insert->journal_id)->first();
            $info = ['journal' => $jourRow->name, 'price' => $jourRow->price, 'file' => asset("assets/uploads/international-publication-orders/" . $fileName), 'username' => getAuth('user', 'name'), 'email' => getAuth('user', 'email'),];
            foreach (DB::table('received_emails')->select("email")->get() as $email) {
                Mail::to($email)->send(new NotificationsInternationalPublishingMail($info));
            }
            return response(['status' => true, 'message' => 'تم ارسال طلبك بنجاح , سوف يتم تحويلك الي صفحة الدفع', 'form' => 'reset', 'redirect' => true, 'to' => userUrl('international-publishing/checkout/' . $insert->id),]);
        }
    }

    public function readNotification($id)
    {
       $noti = DB::table('notifications')->where('id',$id)->update(['read_at'=>now()]);
       $noti = DB::table('notifications')->where('id',$id)->first();
    // dd(json_decode($noti->data));
       if(json_decode($noti->data)->type == 'researche'){
        return redirect('/u/researches/all');
       }elseif (json_decode($noti->data)->type == 'chat') {
        return  redirect('u/chat/'.json_decode($noti->data)->id);
       }
        return redirect()->back();
    }

    public function readNotificationConferenceRequest($type,$noti,$id)
    {
        DB::table('notifications')->where('notifiable_type','App\Models\Admin\Admins')->update(['read_at'=>now()]);
        if ($type == 'conference') {
            return redirect(adminUrl('conference/show/' . $id));
        }
        elseif ($type == 'post') {
            return  redirect(adminUrl('international-publishing/orders/show/' . $id));

        }
        elseif ($type == 'researche') {
            return  redirect(adminUrl('users/user-researches/'));
        }
        elseif ($type == 'chat') {
            return  redirect('admin/users/chat/'.$noti.'/'.$id);
        }

    }
    public function edit($id)
    {
        $row = InternationalPublicationOrders::with(['journal'])->where("id", $id)->where('user_id', getAuth('user', 'id'))->where("payment_response", "0")->first();
        if (!empty($row)) {
            $pageTitle = 'تعديل طلب نشر دولي جديد';
            $spec = InternationalSpecialties::orderBy("id", 'DESC')->where("id", $row->journal->specialty_id)->first();
            $types = InternationalTypes::orderBy("id", 'DESC')->get();
            $specialty = InternationalSpecialties::orderBy("id", 'DESC')->where("type_id", $spec->type_id)->get();
            $journals = InternationalJournals::orderBy("id", 'DESC')->where("specialty_id", $spec->id)->get();
            return view("main.user.international-publishing.edit", compact('pageTitle', 'types', 'row', 'spec', 'specialty', 'journals'));
        } else {
            return redirect("");
        }
    }

    public function update(Request $request)
    {
        $id = $request->id;
        $row = InternationalPublicationOrders::where("user_id", getAuth('user', 'id'))->find($id);
        if (!empty($row)) {
            $journals_all_id = DB::table('international_journals')->select('id')->get();
            $jourIDs = [];
            foreach ($journals_all_id as $jour_id) {
                array_push($jourIDs, $jour_id->id);
            }
            $request->validate(['type' => 'required', 'specialty' => "required", 'journal' => "required|in:" . implode(",", $jourIDs), 'file' => 'nullable|mimes:docx,doc', 'desc' => 'nullable|max:3000',]);
            $fileName = $row->file;
            if ($request->hasFile("file")) {
                @unlink(self::PATH . $row->file);
                $fileName = randomName() . '.' . $request->file->extension();
            }
            $row->journal_id = $request->journal;
            $row->file = $fileName;
            $row->desc = $request->desc;
            if ($row->save()) {
                if ($request->hasFile("file")) {
                    upload($request->file, self::PATH, $fileName);
                }
                return response(['status' => true, 'message' => 'تم تحديث طلبك بنجاح , سوف يتم تحويلك الي صفحة الدفع', 'redirect' => true, 'to' => userUrl('international-publishing/checkout/' . $row->id),]);
            }
        } else {
            return back();
        }
    }

    public function destroy(Request $request)
    {
        $row = InternationalPublicationOrders::where("user_id", getAuth('user', 'id'))->find($request->id);
        if (!empty($row)) {
            if ($row->user_id == getAuth('user', 'id')) {
                @unlink(self::PATH . $row->file);
                $row->delete();
                $request->session()->flash('deleteMessage', 'تم حذف البيانات بنجاح');
            }
        }
        return back();
    }
}
