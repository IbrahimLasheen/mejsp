<?php

namespace App\Http\Controllers;

use Notification;
use App\Models\User;
use App\Models\Journals;
use App\Models\Admin\Admins;
use Illuminate\Http\Request;
use App\Mail\ResiveOrderMail;
use App\Mail\UpdateOrderMail;
use App\Models\UsersResearches;
use Illuminate\Support\Facades\DB;
use App\Notifications\RecivedOrder;
use App\Notifications\ResearcheEdit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
use App\Notifications\ResearcheRequest;
use App\Notifications\ResearcheResponse;
use App\Mail\NotificationsResearchesMail;
use App\Notifications\DeleteResearchDemande;
use App\Mail\DeleteResearchDemande as DeleteResearchDemandeMail;
use Illuminate\Contracts\Encryption\DecryptException;

class ResearchesController extends Controller
{

    const PATH = "assets/uploads/users-researches/";

    public function index()
    {
        $pageTitle = 'ابحاثي';
        $researches = UsersResearches::with(['journal' => function ($q) {
            $q->select('id', 'name');
        }])->where('user_id', getAuth('user', 'id'))->orderBy("id", 'DESC')->get();
        return view("main.user.researches.all", compact('pageTitle', 'researches'));
    }

    public function show($id)
    {
        $pageTitle = 'تفاصيل البحث';
        $research_details = UsersResearches::with(['journal' => function ($q) {
            $q->select('id', 'name');
        }])->orderBy("id", 'DESC')->where('user_id', getAuth('user', 'id'))->find($id);
        if(!$research_details){
            abort(404);
        }
        return view("main.user.researches.details", compact('pageTitle', 'research_details'));
    }

    public function create()
    {
        $pageTitle = 'ارسال بحثك';
        $journals = Journals::select("name", 'id')->get();
        return view("main.user.researches.create", compact('pageTitle', 'journals'));
    }

    public function store(Request $request)
    {
      
        $ids = DB::table('journals')->select('id')->get();
        $journalsIDs = [];
        foreach ($ids as $row) {
            array_push($journalsIDs, $row->id);
        }
        $request->validate([
            'title' => 'required|max:1500',
            'keywords' => 'max:3000',
            'keywords_final' => 'required|max:3000',
            'abstract' => 'required|max:10000',
            'type' => 'required|in:0,1',
            'journal' => "required|in:" . implode(",", $journalsIDs),
            'file' => 'required|mimes:doc,docx',
        ]);
        $fileName = slug(mb_substr($request->title, 0, 75)) . "-" . randomName() . '.' . $request->file->extension();
        $insert = UsersResearches::create([
            'title' => $request->title,
            'keywords' => $request->keywords_final ? $request->keywords_final : $request->keywords,
            'abstract' => $request->abstract,
            'type' => $request->type,
            'journal_id' => $request->journal,
            'file' => $fileName,
            'user_id' => getAuth('user', 'id'),
        ]);
        if ($insert->save()) {
            $admins = Admins::all();
            foreach ($admins as $admin) {

                $requestData = [
                    'id' => $insert->id,
                    'user_id' => getAuth('user', 'id'),
                    'user_name' => getAuth('user', 'name'),
                    'type' => 'researche',
                    'body' => ' لديك  طلب تقديم دراسة جديد',
                ];
                Notification::send($admin, new ResearcheRequest($requestData));
            }
            $user = auth('user')->user();

            $requestData = [
                'id' => $insert->id,
                'user_id' => getAuth('user', 'id'),
                'user_name' => getAuth('user', 'name'),
                'type' => 'researche',
                'body' => 'تم استلام طلب النشر الخاص بك، هو الآن قيد المراجعة، سنبلغك بأخر مستجدات الطلب، يرجى الحرص على الدخول للوحة التحكم الخاصة بك دوريا للاطلاع على حالة طلبك'
            ];

            Notification::send($user, new ResearcheResponse($requestData));
            upload($request->file, self::PATH, $fileName);
            $jourRow = DB::table('journals')->select("name")->where("id", $insert->journal_id)->first();
            $type = '';
            if ($insert->type == 0) {
                $type = 'مفتوح المصدر';

            } else {
                $type = 'مقيد الوصول';
            }
            $info = [
                'mail_title' => 'تم استلام دراستك',
                'mail_details1' => 'تلقينا طلب نشر دراستك',
                'mail_details2' => 'سوف نبلغك باي مستجدات',
                'mail_details3' => 'احرص على الدخول لحسابك دورياً لتفقد حالة الطلب',
                'mail_details4' => '',
                'mail_details5' => '',
                'id' => '',
                'title' => $insert->title,
                'type' => $type,
                'journal' => $jourRow->name,
                'abstract' => $request->abstract,
                'file' => asset(self::PATH . $fileName),
                'username' => getAuth('user', 'name'),
                'email' => getAuth('user', 'email'),
                'status' => 9,
            ];

            $user_email = getAuth('user', 'email');

            foreach (DB::table('received_emails')->select("email")->get() as $email) {
                Mail::to($email)->send(new NotificationsResearchesMail($info));
            }

            Mail::to($user_email)->send(new ResiveOrderMail($info, "تأكيد استلام الدراسة"));
            $pageTitle = 'تأكيد استلام الطلب';
            $request->session()->flash('successMsg', 'تم استلام الطلب بنجاح');

            // return view("main.user.researches.success",compact('pageTitle', 'insert'));
            return response([
                'status' => true,
                'redirect_to_success_page'=>true,
                'order_id'=>$insert->id,
                'message' => 'تم ارسال بحثك بنجاح', 'form' => 'reset',
            ]);
        }
    }

    public function edit($id)
    {
        $row = UsersResearches::where("user_id", getAuth('user', 'id'))->find($id);
        if (!empty($row)) {
            $pageTitle = 'تعديل بحثك';
            $journals = Journals::select("name", 'id')->get();
            return view("main.user.researches.edit", compact('pageTitle', 'journals', 'row'));
        } else {
            return redirect("");
        }
    }
    public function update(Request $request)
    {   
        $id = $request->id;
        $row = UsersResearches::where("user_id", getAuth('user', 'id'))->find($id);

        if (!empty($row)) {
            $ids = DB::table('journals')->select('id')->get();
            $journalsIDs = [];

            foreach ($ids as $jour_row) {
                array_push($journalsIDs, $jour_row->id);
            }
            $request->validate([
                'title' => 'required|max:1500',
                'keywords' => 'max:3000',
                'abstract' => 'required|max:10000',
                'type' => 'required|in:0,1',
                'journal' => "required|in:" . implode(",", $journalsIDs), 'file' => 'nullable|mimes:doc,docx',
            ]);
            $fileName = $row->file;
            if ($request->hasFile("file")) {
                @unlink(self::PATH . $fileName);
                $fileName = slug(mb_substr($request->title, 0, 75)) . "-" . randomName() . '.' . $request->file->extension();
            }
            $row->title = $request->title;
            $row->keywords = $request->keywords_final ? $request->keywords_final : $request->keywords;
            $row->abstract = $request->abstract;
            $row->type = $request->type;
            $row->journal_id = $request->journal;
            $row->file = $fileName;
            if ($row->save()) {
                if ($request->hasFile("file")) {
                    upload($request->file, self::PATH, $fileName);
                }
                
                $etat=" تعديل الطلب من قبل المستخدم";
            $info=[
                'id'=>$id,
                'mail_title'=> 'تم تعديل الطلب من قبل المستخدم',
                'mail_details1'=> 'قام المستخدم '.getAuth('user', 'name').' بالتعديل في الطلب  ' ,
                'mail_details2'=> '',
                'mail_details3'=> '',
                'mail_details4'=> '',
                'mail_details5'=> '',
                'title'=>$row->title,
                'type'=>$row->type,
                'journal'=>$row->journal->name,
                'abstract'=>$row->abstract,
                'file'=>$row->file,
                'username'=>getAuth('user', 'name'),
                'email'=>getAuth('user', 'email'),
                'status'=>$row->status,
                ];
             
                $requestData = [
                    'id' => $id,
                    'user_id' => getAuth('user', 'id'),
                    'user_name' => getAuth('user', 'name'),
                    'type' => 'researche',
                    'body' => ' تعديل طلب من قبل المستخدم : <strong>'.getAuth('user', 'name').'</strong>',
                ];
                $admins = Admins::all();
                foreach ($admins as $admin) {
                    Notification::send($admin, new ResearcheEdit($requestData));

                }
               
                foreach (DB::table('received_emails')->select("email")->get() as $email) {
                    Mail::to($email)->send(new UpdateOrderMail($info,$etat));
                }
                return response(['status' => true, 'message' => 'تم ارسال بحثك بنجاح',]);
            }
        }
    }
    public function destroy(Request $request)
    {
        try {
            $id = Crypt::decryptString($request->id);
            $row = UsersResearches::where("id", $id)->where('user_id', getAuth('user', 'id'))->first();
            if (!empty($row)) {
                @unlink(self::PATH . $row->file);
                $row->delete();
                return back();
            }
        } catch (DecryptException $e) {
        }
        return back();
    }
    public function deleteDemande(Request $request){
        $row = UsersResearches::where("user_id", getAuth('user', 'id'))->find($request->id);

        $etat=" طلب حذف الدراسة من قبل المسنخدم";
        $info=[
            'id'=>$request->id,
            'mail_title'=> '',
            'mail_details1'=> 'قام المستخدم '.getAuth('user', 'name').' بطلب حذف الدراسة  ' ,
            'mail_details2'=> '',
            'mail_details3'=> '',
            'mail_details4'=> '',
            'mail_details5'=> '',
            'title'=>$row->title,
            'type'=>$row->type,
            'journal'=>$row->journal->name,
            'abstract'=>$row->abstract,
            'file'=>$row->file,
            'username'=>getAuth('user', 'name'),
            'email'=>getAuth('user', 'email'),
            'status'=>$row->status,
            ];
         
        $requestData = [
            'id' => $request->id,
            'user_id' => getAuth('user', 'id'),
            'user_name' => getAuth('user', 'name'),
            'type' => 'chat',
            'body' => ' طلب حذف الدراسة من قبل المستخدم  : <strong>'.getAuth('user', 'name').'</strong>',
        ];
        $admins = Admins::all();
        foreach ($admins as $admin) {
            Notification::send($admin, new DeleteResearchDemande($requestData));

        }
        foreach (DB::table('received_emails')->select("email")->get() as $email) {
            Mail::to($email)->send(new DeleteResearchDemandeMail($info,$etat));
        }
        return response(['status' => true, 'message' => 'ok',]);
    }
    public function order_received_page($id){
        $pageTitle = 'تأكيد استلام الطلب';
        
        return view("main.user.researches.success",compact('pageTitle','id'));
    }
    public function old_chats()
    {
        $pageTitle = 'محادثاتي السابقة';
        $researches = UsersResearches::with(['journal' => function ($q) {
            $q->select('id', 'name');
        }])->where('user_id', getAuth('user', 'id'))->orderBy("id", 'DESC')->get();
        return view("main.user.researches.old_chats", compact('pageTitle', 'researches'));
    }
}
