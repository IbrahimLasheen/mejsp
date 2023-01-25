<?php

namespace App\Http\Controllers\Admin;

use DB;
use Auth;
use Crypt;
use Exception;
use Notification;
use App\Models\Chat;
use App\Models\User;
use App\Models\Message;
use App\Models\Payment;
use App\Models\Invoices;
use App\Models\Journals;
use App\Mail\MessageMail;
use App\Events\SendMessage;
use App\Models\Conferences;
use App\Models\InvoiceItems;
use Illuminate\Http\Request;
use App\Mail\ResiveOrderMail;
use App\Notifications\Review;
use App\Models\InvoiceJournal;
use App\Models\UsersResearches;
use App\Notifications\Approved;
use App\Notifications\Canceled;
use App\Notifications\EditChat;
use App\Mail\DeleteResearchReason;
use App\Http\Controllers\Controller;
use App\Notifications\ResearcheEdit;
use Illuminate\Support\Facades\Mail;
use App\Notifications\ResearchDelete;
use App\Notifications\ResearcheAnswer;
use App\Notifications\ResearcheReject;
use App\Notifications\ResearcheApprove;
use App\Models\InternationalPublicationOrders;

class UsersController extends Controller
{
    const PATH = "assets/uploads/user/";
    const IMG_EXT = '.webp';

  public $ending = 15;
  private function endTime()
  {
    return time() + $this->ending * 24 * 60 * 60;
  }
    public function index()
    {

        $query = null;
        $where = null;
        $equal = '=';

        if (isset($_GET['search'])) {
            $query =  trim($_GET['search']);
            $where = 'email';
            $equal = 'like';
        }

        $users = User::orderBy('id', 'DESC')->where($where, $equal, $query)->get();
        return view("admin.users.users", compact("users"));
    }

    public function update_status(Request $request)
    {
        $id = $request->id;
        $row = User::find($id);
        if (!empty($row)) {
            $row->status = $row->status == "0" ? "1" : "0";
            $row->save();
            $request->session()->flash("success", 'تم تحديث حالة المستخدم بنجاح');
            return back();
        } else {
            return back();
        }
    }

    public function show($id)
    {
        $row = User::find($id);
        if (!empty($row)) {

            // Get All conferences
            $conferences = Conferences::with(["confCategory"])->where('user_id', $id)->get();
            $payments    = Payment::where('payment_by', $id)->orderBy('id', 'DESC')->get();

            $InternationalPublicationOrders    = InternationalPublicationOrders::with(["journal" => function ($q) {
                $q->select("id", 'name', 'price');
            }])->where('user_id', $id)->orderBy('id', 'DESC')->get();


            $researches  = UsersResearches::with(["journal" => function ($q) {
                $q->select("id", 'name');
            }])->where('user_id', $id)->orderBy('id', 'DESC')->paginate(5);

            return view("admin.users.show", compact("row", "conferences", "payments", 'researches', 'InternationalPublicationOrders'));
        } else {
            return redirect(adminUrl("users"));
        }
    }

    public function researches()
    {
        
        $rows = UsersResearches::with([
            'journal' => function ($q) {
                $q->select("id", 'name');
            }, 'user' => function ($q) {
                $q->select("id", 'email');
            }
        ])->orderBy("id", 'DESC')->get();
        return view("admin.users.researches", compact('rows'));
    }
    //count
    // baik
    public function user_researches()
    {
        $researches = UsersResearches::with([
            'journal' => function ($q) {
                $q->select("id", 'name');
            }, 'user' => function ($q) {
                $q->select("id", 'email','name','phone');
            }
        ])->orderBy("id", 'DESC')->paginate('10');

        $pageTitle = 'أبحاث المستخدمين';
        return view("admin.user-researches.all", compact('researches','pageTitle'));
    }
    
    public function user_researches_cat($id)
    {
        $researches = UsersResearches::where('status',$id)->with([
            'journal' => function ($q) {
                $q->select("id", 'name');
            }, 'user' => function ($q) {
                $q->select("id", 'email','name','phone');
            }
        ])->orderBy("id", 'DESC')->paginate('15');

        $pageTitle = 'أبحاث المستخدمين';
        return view("admin.user-researches.all", compact('researches','pageTitle'));
    }
    public function user_researche_details($id)
    {
        $research = UsersResearches::with([
            'journal' => function ($q) {
                $q->select("id", 'name');
            }, 'user' => function ($q) {
                $q->select("id", 'email','name','phone');
            }
        ])->find($id);

        $pageTitle = 'تفاصيل البحث';
        return view("admin.user-researches.details", compact('research','pageTitle'));
    }
    
    
    
    public function edit_researches($value,$id)
    {
        $user_researche = UsersResearches::find($id);
        $journal = Journals::findOrFail($user_researche->journal_id);
        $invoice = InvoiceJournal::where('journal_id', $journal->id)->first();
        $user_researche->status = $value;
        $user_in = $user_researche->user->id;
        $user_name = $user_researche->user->name;
        $user_researche->update();
        
        //Subject for email
        
        $etat="";
        
        $researches = UsersResearches::with([
            'journal' => function ($q) {
                $q->select("id", 'name');
            }, 'user' => function ($q) {
                $q->select("id", 'email','name','phone');
            }
        ])->orderBy("id", 'DESC')->paginate('5');
        
        if($value == 1 || $value ==2){
            $etat="تحويل الدراسة للمراجعة";
            $info=[
                'id'=>'',
                'mail_title'=> 'تعديل في حالة الطلب',
                'mail_details1'=> ' قام المراجع بتغيير حالة طلب النشر الخاص بك',
                'mail_details2'=> ' يرجى الدخول لحسابك؛ لتفقد حالة الطلب',
                'mail_details3'=> '',
                'mail_details4'=> '',
                'mail_details5'=> '',
                'title'=>$user_researche->title,
                'type'=>$user_researche->type,
                'journal'=>$user_researche->journal->name,
                'abstract'=>$user_researche->abstract,
                'file'=>$user_researche->file,
                'username'=>$user_researche->user->name,
                'email'=>$user_researche->user->email,
                'status'=>$value,
                ];
            $user = User::where('id', $user_in)->first();
           
            $requestData = [
                'id' => $id,
                'user_id' => $user_in,
                'user_name' => $user_name,
                'type' => 'post',
                'body' => ' تم تحويل طلب النشر الخاص بك للمراجعة، سنبلغك بأخر مستجدات الطلب، يرجى الحرص على الدخول للوحة التحكم الخاصة بك دوريا للاطلاع على حالة طلبك',
            ];
            Notification::send($user, new ResearcheAnswer($requestData));
        }elseif($value == 3){
            $etat="قبول الدراسة للنشر";
            $info=[
                'id'=>'',
                'mail_title'=> 'تهانينا!',
                'mail_details1'=> 'وافقت لجنة المراجعة على نشر دراستك',
                'mail_details2'=> 'الإجراءات التالية للنشر هي:-',
                'mail_details3'=> '١- اعتماد شهادة قبول النشر',
                'mail_details4'=> '٢- جدولة الدراسة ضمن الإصدار التالي للمجلة',
                'mail_details5'=> 'لإتمام الإجراءات يجب سداد رسوم التحكيم والنشر باستخدام الفيزا أو الماستر كارد أو الباي بال',
                'title'=>$user_researche->title,
                'type'=>$user_researche->type,
                'journal'=>$user_researche->journal->name,
                'abstract'=>$user_researche->abstract,
                'file'=>$user_researche->file,
                'username'=>$user_researche->user->name,
                'email'=>$user_researche->user->email,
                'status'=>$value,
                ];
            $user = User::where('id', $user_in)->first();
        
            $requestData = [
                'id' => $id,
                'user_id' =>$user_in,
                'user_name' => $user_name,
                'type' => 'approve',
                'body' => 'تهانينا! تم قبول نشر دراستك بعنوان '.$user_researche->title .' يرجى الدخول للطلب  لاستكمال إجراءات النشر
                ',
            ];
            Notification::send($user, new ResearcheApprove($requestData));
            // send inviues 
            if ($invoice) {
            $item = $invoice->items;
            $invo = new Invoices();
            $invo->email = $user->email;
            $invo->journal_id = $invoice->journal->id;
            $invo->ending = $this->endTime();
            $invo->users_researches_id = $user_researche->id;
            $invo->save();
            if ($invo) {
                foreach ($item as $item) {
                    $invo_items = new InvoiceItems();
                    $invo_items->price = $item->price;
                    $invo_items->service_name = $item->service_name;
                    $invo_items->invoice_id = $invo->id;
                    $invo_items->save();
                }
            }
            $user_email = $user_researche->user->email;
            $etat="قبول الدراسة للنشر";
            $info=[
                'id'=>'',
                'mail_title'=> 'تهانينا!',
                'mail_details1'=> 'وافقت لجنة المراجعة على نشر دراستك',
                'mail_details2'=> 'الإجراءات التالية للنشر هي:-',
                'mail_details3'=> '١- اعتماد شهادة قبول النشر',
                'mail_details4'=> '٢- جدولة الدراسة ضمن الإصدار التالي للمجلة',
                'mail_details5'=> 'لإتمام الإجراءات يجب سداد رسوم التحكيم والنشر باستخدام الفيزا أو الماستر كارد أو الباي بال',
                'title'=>$user_researche->title,
                'type'=>$user_researche->type,
                'journal'=>$user_researche->journal->name,
                'abstract'=>$user_researche->abstract,
                'file'=>$user_researche->file,
                'username'=>$user_researche->user->name,
                'email'=>$user_researche->user->email,
                'status'=>3,
                'link'=>    url('invoice/' . Crypt::encryptString($invo->id))
                ];
                
                
           $mail= Mail::to($user_email)->send(new ResiveOrderMail($info,$etat));
           if($mail){
               $id_send=$user_researche->id;
               $success="تم ارسال الفاتورة بنجاح";
               return back()->with(compact('success','id_send'));
           }
            }
        // end send
        }elseif($value == 4){
            $etat="رفض نشر الدراسة";
            $info=[
                'id'=>'',
                'mail_title'=> 'رفض طلب النشر',
                'mail_details1'=> 'نأسف لإبلاغك برفض لجنة المراجعة لطلب النشر الخاص بك',
                'mail_details2'=> 'لا تتردد بتقديم دراساتك المستقبلية للنشر بالمجلة',
                'mail_details3'=> '',
                'mail_details4'=> '',
                'mail_details5'=> '',
                'title'=>$user_researche->title,
                'type'=>$user_researche->type,
                'journal'=>$user_researche->journal->name,
                'abstract'=>$user_researche->abstract,
                'file'=>$user_researche->file,
                'username'=>$user_researche->user->name,
                'email'=>$user_researche->user->email,
                'status'=>$value,
                ];
             $user = User::where('id', $user_in)->first();
 
            $requestData = [
                'id' => $id,
                'user_id' => $user_in,
                'user_name' => $user_name,
                'type' => 'reject',
                'body' => 'نعتذر، تم رفض نشر دراستك بعنوان '.$user_researche->title .' بسبب عدم مراعاة معايير النشر بالمجلة
                لا تتردد بإرسال أعمالك البحثية مستقبلا
                ',
            ];
            Notification::send($user, new ResearcheReject($requestData));
        }elseif($value == 5){
            $etat="تعديل مطلوب في الدراسة";
            $info=[
                'id'=>$user_researche->id,
                'mail_title'=> 'وردك رد من المراجع',
                'mail_details1'=> 'قام المراجع بإضافة تعليقات مطلوب تنفيذها في دراستك',
                'mail_details2'=> '',
                'mail_details3'=> '',
                'mail_details4'=> '',
                'mail_details5'=> '',
                'title'=>$user_researche->title,
                'type'=>$user_researche->type,
                'journal'=>$user_researche->journal->name,
                'abstract'=>$user_researche->abstract,
                'file'=>$user_researche->file,
                'username'=>$user_researche->user->name,
                'email'=>$user_researche->user->email,
                'status'=>$value,
                ];
                $user = User::where('id', $user_in)->first();

                $requestData = [
                    'id' => $id,
                    'user_id' => $user_in,
                    'user_name' => $user_name,
                    'type' => 'post',
                    'body' => '   لديك تعديل مطلوب في دراستك يمكنك فتح الشات من اجل التفاصيل',
                ];
                Notification::send($user, new ResearcheEdit($requestData));
        }
        
            
        $user_email = $user_researche->user->email;

        if($value != 5 && $value!=3){
            Mail::to($user_email)->send(new ResiveOrderMail($info,$etat));
        }
        
        $pageTitle = 'أبحاث المستخدمين';
        return redirect()->back()->with('researches',$researches)->with('pageTitle',$pageTitle);
        
    }
    
    public function user_researches_destroy(Request $request)
    {
      
        $id = $request->id;
        $row = UsersResearches::find($id);

        $user = $row->user;

        $requestData = [
            'id' => $id,
            'user_id' => $user->id,
            'user_name' => $user->name,
            'type' => 'delete',
            'body' => 'نعتذر، تم حذف دراستك بعنوان '.$row->title .' بسبب '.$request->reason.'
            لا تتردد بإرسال أعمالك البحثية مستقبلا 
            ',
        ];
       


        if (!empty($row)) {
            deleteFile(public_path("assets/uploads/users-researches/"), $row->file);
        }
        if ($row->delete()) {
            try{
                $etat="إشعار بحذف طلب النشر";
                $info=[
                    'id'=>'',
                    'mail_title'=> 'حذف الطلب ',
                    'mail_details1'=> 'نأسف لإبلاغك بحذف لجنة المراجعة لطلب النشر الخاص بك',
                    'mail_details2'=> 'لا تتردد بتقديم دراساتك المستقبلية للنشر بالمجلة',
                    'mail_details3'=> '',
                    'mail_details4'=> '',
                    'mail_details5'=> '',
                    'title'=>$row->title,
                    'type'=>$row->type,
                    'journal'=>$row->journal->name,
                    'abstract'=>$row->abstract,
                    'file'=>$row->file,
                    'reason'=> $request->reason
                    ];
                Mail::to($user->email)->send(new DeleteResearchReason($info,$etat));
                
                Notification::send($user, new ResearchDelete($requestData));
                return response()->json([
                    'message' => 'deleted'
                ]);
            }
            catch(Exception $ex){
                return response()->json([
                    'message' => $ex->getMessage()
                ]);
            };

            $request->session()->flash("success", 'تم  الحذف بنجاح');
            return response()->json([
                'message' => 'deleted'
            ]);
        }
    }
    
    // chat  
    public function chat($id, Request $request){
        $user_researches = UsersResearches::findOrFail($id);
        
        if ($request->notification_id) {
            $noti = DB::table('notifications')->where('id', $request->notification_id)->update(['read_at' => NOW()]);

        }
   
            $messages = Message::where('research_id',$id)->get();
        
            foreach($messages as $item){
                $item->a_show = 1;
                $item->update();
            }
            $research_id = $id;
            $pageTitle = 'الرسائل ';
            if($user_researches->status == 5)
            {
                return view("admin.user-researches.chat", compact('messages','pageTitle','research_id','user_researches'));

            }else{
                return view("admin.user-researches.closed_chat", compact('messages','pageTitle','research_id','user_researches')); 
            }
        

        
    }
    
    public function send_facture(request $request){
        
        $request->validate([
        'link'=>'required|url'
        ]);
        
        $user_researche = UsersResearches::where('id',$request->research_id)->first();
        
          
            $user_email = $user_researche->user->email;
            $etat="قبول الدراسة للنشر";
            $info=[
                'id'=>'',
                'mail_title'=> 'تهانينا!',
                'mail_details1'=> 'وافقت لجنة المراجعة على نشر دراستك',
                'mail_details2'=> 'الإجراءات التالية للنشر هي:-',
                'mail_details3'=> '١- اعتماد شهادة قبول النشر',
                'mail_details4'=> '٢- جدولة الدراسة ضمن الإصدار التالي للمجلة',
                'mail_details5'=> 'لإتمام الإجراءات يجب سداد رسوم التحكيم والنشر باستخدام الفيزا أو الماستر كارد أو الباي بال',
                'title'=>$user_researche->title,
                'type'=>$user_researche->type,
                'journal'=>$user_researche->journal->name,
                'abstract'=>$user_researche->abstract,
                'file'=>$user_researche->file,
                'username'=>$user_researche->user->name,
                'email'=>$user_researche->user->email,
                'status'=>3,
                'link'=>$request->link
                ];
                
                
           $mail= Mail::to($user_email)->send(new ResiveOrderMail($info,$etat));
           if($mail){
               $id_send=$user_researche->id;
               $success="تم ارسال الفاتورة بنجاح";
               return back()->with(compact('success','id_send'));
           }
        
    }
    
    public function chat_store(request $request){
        
        $request->validate([
        'message'=>'max:1500',
        'file'=>'mimes:doc,docx,pdf,jpg,png,jpeg',
        ]);
        
        // get File
        $file =$request->file;
        
        //get Host Webiste
        $host = $request->getSchemeAndHttpHost();
        
        $message = new Message;
        $message->message = nl2br($request->message);
        $message->research_id = $request->research_id;
        $message->a_show = 1;
        $message->u_show = 0;
        $message->user_id = 1;
        
        //verify requests File 
        
        if(!empty($file)){
        $new_file =random_int(100000, 999999)."_".time().$file->getClientOriginalName();
        $message->file=$host."/admin-assets/uploads/chats_pictures/".$new_file;
        }else{
        $new_file="";
        $message->file=$new_file;
        }
        
        $user_researches = UsersResearches::where('id',$request->research_id)->first();
        $user_in = $user_researches->user->id;

        
        $research = UsersResearches::where('id',$message->research_id)->pluck('user_id')->first();

        $user_email = User::where('id',$research)->pluck('email')->first();
        
        $etat="تعديل مطلوب في الدراسة";
    
         $info=[
                'id'=>$request->research_id,
                'mail_title'=> 'وردك رد من المراجع',
                'mail_details1'=> 'قام المراجع بإضافة تعليقات مطلوب تنفيذها في دراستك.',
                'mail_details2'=> '',
                'mail_details3'=> '',
                'mail_details4'=> '',
                'mail_details5'=> '',
                'title'=>$user_researches->title,
                'type'=>$user_researches->type,
                'journal'=>$user_researches->journal->name,
                'abstract'=>$user_researches->abstract,
                'file'=>$user_researches->file,
                'username'=>$user_researches->user->name,
                'email'=>$user_researches->user->email,
                'status'=>7,
                ];
                

        if($message->save())
        {
            $user = User::where('id', $user_in)->first();

            $requestData = [
                'id' => $user_researches->id,
                'user_id' => $user_in,
                'user_name' => $user->name,
                'type' => 'chat',
                'body' => 'بخصوص طلب نشر الدراسة بعنوان '.$user_researches->title .' وردك تعليقات من المراجع
                ',
            ];
            Notification::send($user, new EditChat($requestData));
            if(!empty($file)){
                // $file->move("admin-assets/uploads/chats_pictures",$new_file);
                upload($file,"admin-assets/uploads/chats_pictures/",$new_file);
            }
            
            Mail::to($user_email)->send(new ResiveOrderMail($info,$etat));
            //send message pusher
            event(new SendMessage($message,$user_in));
        }

        $messages = Message::where('research_id',$request->research_id)->get();
        $research_id = $request->research_id;
        $pageTitle = 'الرسائل ';
        return redirect()->back()->with('messages',$messages)->with('pageTitle',$pageTitle)->with('research_id',$research_id);
    }
    
    
    
    
    //baik


    public function destroy(Request $request)
    {
        $id = $request->id;
        $row = User::find($id);
        if (!empty($row)) {
            deleteFile(self::PATH, $row->image);
            $row->delete();
        }
        return back();
    }


    public function researches_destroy(Request $request)
    {
        
        $id = $request->id;
        $row = UsersResearches::find($id);
        if (!empty($row)) {
            deleteFile(public_path("assets/uploads/users-researches/"), $row->file);
            $row->delete();
        }
        
    }
}
