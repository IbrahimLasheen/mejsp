<?php

namespace App\Http\Controllers;

use App\Mail\NotificationsConferencesMail;
use App\Mail\SendCertificateMail;
use App\Models\Admin\Admins;
use App\Models\ConferenceCategories;
use App\Models\Conferences;
use App\Models\Payment;
use App\Notifications\ConferenceRequest;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Notification;
class ConferencesController extends Controller
{
    public function index()
    {
        $pageTitle = ' طلبات المؤتمرات';
        $conferences = Conferences::with(['user', 'confCategory'])->orderBy("id", 'DESC')->get();
        return view("admin.conferences.all", compact('pageTitle', 'conferences'));
    }
    public function show($id)
    {
        $conf = Conferences::with(["confCategory", 'user'])->where("id", $id)->first();
        if (!empty($conf)) {
            $pay = Payment::where('for_conference', $id)->first();
            return view("admin.conferences.show", compact("conf", "pay"));
        } else {
            return redirect(adminUrl("conference/all"));
        }
    }
    public function send_certificate(Request $request)
    {
        $id = $request->id;
        $expiry_time = time() + 86400;
        try {
            $id = Crypt::decryptString($id);
            $conferences = Conferences::with(['user' => function ($q) {
                $q->select("name", 'email', 'id');
            }])->where("id", $id)->first();
            $conf = $conferences->first();
            $info = ['username' => $conf->user->name, 'link' => url("download-my-certificate/" . Crypt::encryptString($id)),];
            Mail::to($conf->user->email)->send(new SendCertificateMail($info));
            return response(['status' => true, 'message' => 'تم ارسال الشهادة بنجاح',]);
        } catch (DecryptException $e) {
        }
    }
    public function all_conference()
    {
        $pageTitle = 'طلبات حضور المؤتمرات';
        $conferences = Conferences::with(['confCategory'])->where("user_id", getAuth('user', 'id'))->get();
        return view("main.user.conference.all", compact('pageTitle', 'conferences'));
    }
    public function create()
    {
        $pageTitle = 'طلب شهادة حضور مؤتمر';
        $conferenceCategories = ConferenceCategories::orderBy("id", "DESC")->select('id', "name", 'price', 'without_research')->get();
        return view("main.user.conference.create", compact('pageTitle', 'conferenceCategories'));
    }
    public function store(Request $request)
    {
        $ids = DB::table('conference_categories')->select('id')->get();
        $conference_categoriesIDs = [];
        foreach ($ids as $row) {
            array_push($conference_categoriesIDs, $row->id);
        }
        $request->validate(["research_title" => 'nullable|max:255', 'category' => "required|in:" . implode(",", $conference_categoriesIDs),]);
        $category = $request->category;
        $research_title = $request->research_title;
        $insert = Conferences::create(["category" => $category, "research_title" => $research_title, "user_id" => getAuth('user', 'id'), "payment_response" => "0",]);
        if ($insert->save()) {
            $admins = Admins::all();
            foreach ($admins as $admin) {

            $requestData = [
                'id' => $insert->id,
                'user_id' => getAuth('user', 'id'),
                'user_name' => getAuth('user', 'name'),
                'type' => 'conference',
                'body' => ' لديك  طلب الانضمام لمؤتمر دولي جديد',
            ];
            Notification::send($admin, new ConferenceRequest($requestData));
            
            }
            $categoryRow = DB::table('conference_categories')->select("name", 'price')->where('id', $category)->first();
            $info = ['type' => $categoryRow->name, 'price' => $categoryRow->price, 'research_title' => $research_title, 'username' => getAuth('user', 'name'), 'email' => getAuth('user', 'email'),];
            foreach (DB::table('received_emails')->select("email")->get() as $email) {
                Mail::to($email)->send(new NotificationsConferencesMail($info));
            }
            return response(['status' => true, 'message' => 'تم ارسال طلبك بنجاح , سوف يتم تحويلك الي صفحة الدفع', 'form' => 'reset', 'redirect' => true, 'to' => userUrl('conference/checkout/' . $insert->id),]);
        }
        return back();
    }
    public function edit($id)
    {
        $row = Conferences::with("confCategory")->find($id);
        if (!empty($row)) {
            $pageTitle = 'تعديل شهادة حضور مؤتمر';
            $conferenceCategories = ConferenceCategories::orderBy("id", "DESC")->select('id', "name", 'price', 'without_research')->get();
            return view("main.user.conference.edit", compact('pageTitle', 'conferenceCategories', 'row'));
        } else {
            return redirect("");
        }
    }
    public function update(Request $request)
    {
        $row = Conferences::where("id", $request->id)->where('user_id', getAuth('user', 'id'))->where("payment_response", "0");
        $row_first = $row->first();
        if (!empty($row_first)) {
            $ids = DB::table('conference_categories')->select('id')->get();
            $conference_categoriesIDs = [];
            foreach ($ids as $tttt) {
                array_push($conference_categoriesIDs, $tttt->id);
            }
            $request->validate(["research_title" => 'nullable|max:255', 'category' => "required|in:" . implode(",", $conference_categoriesIDs),]);
            $category = $request->category;
            $research_title = $request->research_title;
            $upd = $row->update(["category" => $category, "research_title" => $research_title,]);
            return response(['status' => true, 'message' => 'تم تحديث طلبك بنجاح , سوف يتم تحويلك الي صفحة الدفع', 'form' => 'reset', 'redirect' => true, 'to' => userUrl('conference/checkout/' . $row_first->id),]);
        }
    }
    public function destroy(Request $request)
    {
        $row = Conferences::where("user_id", getAuth('user', 'id'))->find($request->id);
        if (!empty($row)) {
            if (!empty($row)) {
                if ($row->user_id == getAuth('user', 'id')) {
                    $row->delete();
                    $request->session()->flash('deleteMessage', 'تم حذف البيانات بنجاح');
                }
            }
        }
        return back();
    }
    public function get_typy_of_conferences(Request $request)
    {
        $row = ConferenceCategories::select("without_research", 'price')->where("id", $request->id)->first();
        return json_decode($row);
    }
}
