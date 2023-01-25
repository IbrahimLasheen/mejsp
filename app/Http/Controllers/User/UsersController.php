<?php

namespace App\Http\Controllers\User;

use PDF;
use Auth;
use Session;
use Notification;
use App\Models\User;
use App\Models\Message;
use App\Models\Articles;
use App\Models\Journals;
use App\Models\Services;
use App\Mail\Message2Mail;
use App\Events\SendMessage;
use App\Models\Conferences;
use Illuminate\Support\Str;
use App\Models\Admin\Admins;
use Illuminate\Http\Request;

use App\Mail\ResiveOrderMail;
use App\Notifications\Review;
use App\Models\InvoiceJournal;
use App\Models\UsersResearches;
use App\Notifications\Approved;
use App\Notifications\Canceled;
use App\Notifications\EditChat;
use App\Models\InvoiceJournalItem;
use Illuminate\Support\Facades\DB;


use App\Mail\EmailVerificationMail;
use App\Http\Controllers\Controller;
use App\Notifications\ResearcheEdit;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
use App\Notifications\ResearcheAnswer;
use App\Notifications\ResearcheReject;
use App\Notifications\ResearcheApprove;
use Illuminate\Contracts\Encryption\DecryptException;

class UsersController extends Controller
{
    const PATH = "assets/uploads/user/";
    const IMG_EXT = '.webp';
    const RESEARCHES_PATH = "assets/uploads/users-researches/";



    public function settings(Request $request)
    {
        return view("main.user.settings");
    }

    // Update Main Data
    public function update(Request $request)
    {

        // validate
        $request->validate([
            'name'     => 'required|max:100',
            'email'    => 'required|unique:users,email,' . getAuth('user', 'id') . '|max:200|regex:/[-0-9a-zA-Z.+_]+@[-0-9a-zA-Z.+_]+.[a-zA-Z]{2,4}/',
            'phone'    => 'required|unique:users,phone,' . getAuth('user', 'id') . '|regex:/[0-9]/|numeric|digits_between:8,14',
            'password' => 'nullable|min:6|max:255',
            'qualification'   => 'required|max:150',
            'country_code'    => 'required|regex:/[0-9]/|numeric|digits_between:1,7',
        ], [
            // Name
            'name.required' => 'هذا الحقل مطلوب',
            'name.max' => 'يجب ان لا يتعدي الاسم 100 حرف',
            'name.regex' => 'صيغة الاسم غير صحيحة',
            // email
            'email.required' => 'هذا الحقل مطلوب',
            'email.unique' => 'البريد الالكتروني تم استخدامة من قبل',
            'email.max' => 'يجب ان لا يتعدي الاسم 200 حرف',
            'email.regex' => 'صيغة البريد الالكتروني غير صحيحة',
            // phone
            'phone.required' => 'هذا الحقل مطلوب',
            'phone.regex' => 'صيغة رقم الهاتف غير صحيحة',
            'phone.unique' => 'رقم الهاتف تم استخدامة من قبل',
            // password
            'password.required' => 'هذا الحقل مطلوب',
            'password.min' => 'يجب ان لا يقل عن 6 احرف',
            'password.max' => 'يجب ان لا يتعدي عن 255 حرف',
            // qualification
            'qualification.required' => 'هذا الحقل مطلوب',
            'qualification.max' => 'يجب ان لا يتعدي الاسم 150 حرف',
            // country_code
            'country_code.required' => 'هذا الحقل مطلوب',
            'country_code.regex' => 'صيغة كود الدوله غير صحيحة',
        ]);

        // Get Row For Update
        $row = User::find(getAuth('user', 'id'));

        // Check If Password Change Or No
        $password = $request->password == NULL ? $row->password : Hash::make($request->password);

        // Update Rows
        $row->name  = formatText($request->name);
        $row->email = $request->email;
        $row->phone = $request->phone;
        $row->password =  $password;
        $row->qualification = $request->qualification;
        $row->country_code =  $request->country_code;

        // Successfully Result
        if ($row->save()) {
            $request->session()->flash("successMsg", 'تم تحديث البيانات بنجاح');
            return back();
        }
    }
    // update_profile_image
    public function update_profile_image(Request $request)
    {

        // Validate
        $request->validate([
            'image' => 'required|mimes:jpeg,jpg,png|max:3145728'
        ]);


        deleteFile(self::PATH, getAuth("user", 'image'));
        $update = User::find(getAuth("user", 'id')); // Get Doctor Data
        $imgName = randomName(self::IMG_EXT);
        $update->image = $imgName;

        // Check If Save Success
        if ($update->save()) {

            image($request->image, self::PATH, $imgName, 128, 128); // Upload New Image
            $response = [
                'reload'  => true,
            ];

            return response($response);
        }
    }


    public function send_email_verification(Request $request)
    {
        $email = getAuth('user', 'email');
        $id    = getAuth('user', 'id');

        $row = User::where("id", $id)->whereNull("email_verified_at")->first();

        if (!empty($row)) {
            $data = [
                "link" => userUrl("email-verification/" . Crypt::encryptString($id))
            ];
            Mail::to($email)->send(new EmailVerificationMail($data));
            $request->session()->flash('success_email_verification', 'تم ارسال رسالة تأكيد الي حسابك الالكتروني');
        } else {
            $request->session()->flash('success_email_verification', 'تم  تأكيد حسابك الالكتروني من قبل');
        }
        return back();
    }

    public function email_verification($token)
    {
        $id = getAuth('user', 'id');
        $id_token = request()->segment(3);


        try {
            $id_token = Crypt::decryptString($id_token);

            if ($id_token == $id) {
                $row = User::where("id", $id)->whereNull("email_verified_at")->first();
                if (!empty($row)) {
                    $row->email_verified_at = now();
                    $row->save();
                }
            }
        } catch (DecryptException $e) {
        }
        return redirect(userUrl("dashboard"));
    }
    
    //baik
    
    public function chat($id){
        $services = Services::where('show_in_chat',1)->inRandomOrder()->take(3)->get();
        $articles = Articles::where('show_in_chat',1)->inRandomOrder()->select('title','slug')->take(4)->get();
        $user_researches = UsersResearches::with('user')->where('id',$id)->first();
        
            
            $auth_id = Auth::guard('user')->user()->id;
        
            if($user_researches->user_id == $auth_id){
                $messages = Message::where('research_id',$id)->get();
                foreach($messages as $item){
                    $item->u_show = 1;
                    $item->update();
                }
                $research_id = $id;
                $pageTitle = 'الرسائل ';
                if($user_researches->status == 5)
                {
                return view("main.user.researches.chat", compact('messages','pageTitle','research_id','user_researches','services','articles'));
                }
                else
                {
                    return view("main.user.researches.closed_chat", compact('messages','pageTitle','research_id','user_researches','services','articles'));   
                }

        }else{
            return redirect('/u/dashboard');
            //abort(404);
        }
    
        
        
        
    }
    
    public function chat_store(request $request){
        
        $request->validate([
        'message'=>'max:1500',
        'file'=>'mimes:doc,docx,pdf,jpg,png,jpeg',
        ]);
        
        $auth_id = Auth::guard('user')->user()->id;
        
        // get File
        $file =$request->file;
        
        //get Host Webiste
        $host = $request->getSchemeAndHttpHost();
    
        
        $message = new Message;
        $message->message =nl2br($request->message);
        $message->research_id = $request->research_id;
        $message->a_show = 0;
        $message->u_show = 1;
        
        $message->user_id = $auth_id ;
        
        //verify requests File 
        
        if(!empty($file)){
        $new_file =$auth_id."_".time().$file->getClientOriginalName();
        $message->file=$host."/admin-assets/uploads/chats_pictures/".$new_file;
        }else{
        $new_file="";
        $message->file=$new_file;
        }
        
        $user_researches = UsersResearches::where('id',$request->research_id)->first();
        $fileName = $user_researches->file;
        if ($request->hasFile("file")) {
            // @unlink(self::PATH . $fileName);
            $fileName = slug(mb_substr(Str::random(5), 0, 75)) . "-" . randomName() . '.' . $request->file->extension();
            upload($request->file, self::RESEARCHES_PATH, $fileName);
            $user_researches->file =$fileName;
            $user_researches->save();
        }
   
        $user_in = $user_researches->user->id;

        $info=[
                'id'=>$request->research_id,
                'mail_title'=> 'رد من المؤلف',
                'mail_details1'=> 'قام المؤلف بالرد على تعليقات المراجع.',
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
                'status'=>6,
                ];
                
        
        if($message->save()){
            $admins = Admins::get();
            $requestData = [
                'id' => $user_researches->id,
                'user_id' => $user_in,
                'user_name' => $user_researches->user->name,
                'type' => 'chat',
                'body' => 'بخصوص طلب نشر الدراسة بعنوان '.$user_researches->title .
                ' وردك تعليقات  
                ',
            ];
            foreach($admins as $admin) {
                Notification::send($admin, new EditChat($requestData));
            }
         
            if(!empty($file)){
                // $file->move("admin-assets/uploads/chats_pictures",$new_file);
                upload($file,"admin-assets/uploads/chats_pictures/",$new_file);
            }
            foreach(DB::table('received_emails')->select("email")->get()as $email)
            {
                Mail::to($email)->send(new ResiveOrderMail($info,"تم الرد من المؤلف"));
            }
            event(new SendMessage($message,$user_in));
            
        }

        $messages = Message::where('research_id',$request->research_id)->get();
        $research_id = $request->research_id;
        $pageTitle = 'الرسائل ';
        return redirect()->back()->with('messages',$messages)->with('pageTitle',$pageTitle)->with('research_id',$research_id);
    }


    /**
     * Download certificate
     */
    public function download_certificate($token_id)
    {

        try {

            $token_id  = Crypt::decryptString($token_id);

            $row = Conferences::with(['user' => function ($q) {
                $q->select("name", 'id');
            }])->select('id', 'user_id')->where("id", $token_id)->first();

            if (empty($row)) {
                return view("pages.notfound");
            } else {
                $data = [
                    'name' => $row->user->name,
                ];

                $pdf = PDF::loadView('pdf.conf', $data);
                return $pdf->stream('test.pdf');
            }
        } catch (DecryptException $e) {
            return redirect('');
        }
    }
    public function countPublicationPrices() {
        $jour = Journals::get();
        return view("main.user.count-publication-prices", compact('jour'));
    }
    public function countPublicationPricesPost(Request $request) {
        $request->validate([
            'journal_id' => 'required',
            'default_page_count' => 'required'
            ]);
        $journal = InvoiceJournal::where('journal_id',$request->journal_id)->first();
        $page_count = $journal->default_page_count;
        $main_price = $journal->items->sum('price');
        if ($page_count < $request->default_page_count) {
            $pages = $request->default_page_count - $page_count;
            $price = $main_price + $pages * $journal->extra_page_price;
            // for ($i = 0; $i <= $pages; $i++) {
            //     return $main_price;
            //     $price[] = round($main_price) + round($journal->extra_page_price);
            // }
        } else {
            $price = $main_price;
        }
        $price = $price + ($price * 5)/100;
        $message = ' نشر عدد ' 
        . $request->default_page_count
        . ' صفحة في  ' . $journal->journal->name 
        . ' سوف يكلفك مبلغ : ' 
        . ' ' .$price . ' (دولار أمريكي)';
        Session::flash('message', $message); 
        return redirect()->back()->with('default_page_count', $request->default_page_count);
        
    }
}
