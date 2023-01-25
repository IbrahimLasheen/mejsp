<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\Invoices;
use App\Models\Journals;
use App\Models\Services;
use App\Models\Versions;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\InvoiceJournal;
use App\Models\UsersResearches;
use App\Models\JournalsResearches;
use Illuminate\Support\Facades\DB;
use App\Models\InternationalCredits;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class JournalsController extends Controller
{
    const PATH = "assets/uploads/journals/";
    const IMG_EXT = '.webp';
    public $months = ["يناير", "فبراير", "مارس", "أبريل", "مايو", "يونيو", "يوليو", "أغسطس", "سبتمبر", "أكتوبر", "نوفمبر", "ديسمبر"];
    public $versions = ["الأول","الحادي", "الثاني", "الثالث", "الرابع", "الخامس", "السادس", "السابع", "الثامن", "التاسع", "العاشر","الحادي عشر"];
    
    private function rules($request, $type = ['store', 'update'], $uniqueId = null)
    {
        $years  = date('Y') . "," . date('Y') + 1 . "," . date('Y') + 2 . "," . date('Y') + 3 . "," . date('Y') + 4 . "," . date('Y') + 5;
        $checkField = $type == "update" ? "nullable" : "required";
        $uniqueId = $uniqueId != null ? "," . $uniqueId : $uniqueId;
        $request->validate(['logo' => $checkField . '|mimes:jpeg,jpg,png,svg,webp|max:10000', 'cover' => $checkField . '|mimes:jpeg,jpg,png,svg,webp|max:10000', 'name' => 'required|max:255|unique:journals,name' . $uniqueId, 'meta_desc' => 'required|max:1500', 'impact' => 'nullable|max:60', 'issn' => 'nullable|max:60', 'next_version' => 'nullable|max:255', 'day' => 'required|digits_between:1,31|numeric|min:1|max:31','month' => "required|in:" . implode(',', $this->months),'year' =>  'required|in:' . $years, 'country_code' => 'required|numeric', 'phone' => 'required|numeric', 'email' => 'required|max:150', 'address' => 'required|max:255']);
    }
    private function uploadLogo($inputFile, $randName)
    {
        image($inputFile, self::PATH, $randName, 125, 125);
    }
    private function uploadCover($inputFile, $randName)
    {
        image($inputFile, self::PATH, $randName, 460, 640);
    }
    public function index()
    {
        $pageTitle = 'المجلات';
        $journals = Journals::orderBy("id", 'DESC')->get();
        $months_names = $this->months;
        return view("admin.journals.journals", compact("pageTitle", "journals","months_names"));
    }
    public function create()
    {
        $pageTitle = 'اضافة مجلة جديدة';
        return view("admin.journals.create", compact("pageTitle"));
    }
    public function store(Request $request)
    {
        $this->rules($request);
        $logoName = randomName(self::IMG_EXT);
        $coverName = randomName(self::IMG_EXT);
        
        $month_position = array_search($request->month,$this->months)+1;
        $request['next_version'] = $request->year.'-'.$month_position.'-'.$request->day;

        $insert = Journals::create(['name' => $request->name, 'slug' => slug($request->name), 'impact' => $request->impact, 'issn' => $request->issn, 'meta_desc' => $request->meta_desc, 'cover' => $coverName, 'logo' => $logoName, 'next_version' => $request->next_version, 'address' => $request->address, 'email' => $request->email, 'country_code' => $request->country_code, 'phone' => $request->phone, 'brief_desc' => $request->brief_desc, 'reviewers_instructions' => $request->reviewers_instructions, 'authors_instructions' => $request->authors_instructions, 'ethics' => $request->ethics, 'publication_pricing' => $request->publication_pricing, 'added_by' => getAuth('admin', 'id'),]);
        if ($insert->save()) {
            image($request->logo, self::PATH, $logoName, 125, 125);
            image($request->cover, self::PATH, $coverName, 460, 640);
            $invioce_journal = new InvoiceJournal();
            $invioce_journal->journal_id = $insert->id;
            $invioce_journal->save();
            return response(['status' => true, 'message' => 'تم اضافة المجلة بنجاح', 'form' => 'reset']);
        }
    }
    public function edit($id)
    {
        $pageTitle = 'تعديل مجلة';
        $row = Journals::where('id', $id)->first();
        $last_version = Versions::where('journal_id',$row->id)->latest()->first();
        $last_version_name = $last_version ? $last_version->version : '';

        if (!empty($row)) {
            return view("admin.journals.edit", compact("pageTitle", 'row','last_version_name'));
        } else {
            return redirect(adminUrl('journals'));
        }
    }
    public function update(Request $request)
    {
        $id = $request->id;
        $this->rules($request, 'update', $id);
        $journals = Journals::where("id", $id);
        $journalsRow = $journals->first();
        $logoName = $journalsRow->logo;
        $coverName = $journalsRow->cover;
        if ($request->hasFile('logo')) {
            $logoName = randomName(self::IMG_EXT);
        }
        if ($request->hasFile('cover')) {
            $coverName = randomName(self::IMG_EXT);
        }
        $month_position = array_search($request->month,$this->months)+1;
        $request['next_version'] = $request->year.'-'.$month_position.'-'.$request->day;
        if(!$request['next_version_name']){
            $this->validate($request,[
                'next_version_name'=>'string|required'
            ],['next_version_name.required'=>'اسم الاصدار القادم مطلوب']);
        }

        $update = $journals->update(['name' => $request->name, 'slug' => slug($request->name), 'impact' => $request->impact, 'issn' => $request->issn, 'meta_desc' => $request->meta_desc, 'cover' => $coverName, 'next_version' => $request->next_version, 'logo' => $logoName, 'address' => $request->address, 'email' => $request->email, 'country_code' => $request->country_code, 'phone' => $request->phone, 'brief_desc' => $request->brief_desc, 'reviewers_instructions' => $request->reviewers_instructions, 'authors_instructions' => $request->authors_instructions, 'ethics' => $request->ethics, 'publication_pricing' => $request->publication_pricing,'next_version_name'=>$request['next_version_name']]);
        if ($update > 0) {
            if ($request->hasFile('logo')) {
                @unlink(self::PATH . $journalsRow->logo);
                $this->uploadLogo($request->logo, $logoName);
            }
            if ($request->hasFile('cover')) {
                @unlink(self::PATH . $journalsRow->cover);
                $this->uploadCover($request->cover, $coverName);
            }
            return response(['status' => true, 'message' => 'تم تحديث المجلة بنجاح',]);
        }
    }
    public function destroy(Request $request)
    {
        try {
            $id = Crypt::decryptString($request->id);
            $row = Journals::find($id);
            if (!empty($row)) {
                @unlink(self::PATH . $row->logo);
                @unlink(self::PATH . $row->cover);
                $row->delete();
                $request->session()->flash('statusMsg', 'تم حذف المجلة بنجاح');
            }
        } catch (DecryptException $e) {
            return back();
        }
        return back();
    }
    public function journals(Journals $journals_db, Versions $versions_db)
    {
        $q = NULL;
        $column = NULL;
        $operator = NULL;
        if (isset($_GET['name'])) {
            $column = "name";
            $q = "%" . trim($_GET['name']) . "%";
            $operator = 'like';
        }
        $rows = DB::table($journals_db->table)->orderBy("id", "ASC")->where($column, $operator, $q);
        $journals = $rows->paginate(10);
        $count = $rows->count();
        $services = Services::get();
        return view("main.journals.all", compact('journals', "count", 'services'));
    }
    public function show(Journals $journals_db, Team $team_db, Versions $versions_db, InternationalCredits $inter_db, $slug)
    {
   
        $row = DB::table($journals_db->table)->where("slug", $slug)->first();
        if (empty($row)) {
            return redirect("journals");
        }
        $internationalCredits = DB::table($inter_db->table)->where("journal_id", $row->id)->orderBy("id", "DESC")->get();
        $team = DB::table($team_db->table)->where("journal_id", $row->id)->orderBy("id", "DESC")->get();
        $versions = DB::table($versions_db->table)->where("journal_id", $row->id)->orderBy("id", "DESC")->get();
        $services = Services::orderBy("id", "DESC")->get();

        // $new_version_exists = Versions::where('journal_id',$row->id)
        // ->where('year',date('Y'))
        // ->where('month',date('m'))
        // ->where('day',date('d'))
        // ->first();
        // if(!$new_version_exists && strtotime($row->next_version) && (date('Y-m-d',strtotime($row->next_version)) == date('Y-m-d')))
        // {
        //     //get date of last version
        //     $next_version_name = $row->next_version_name;
        //     $last_version =  Versions::where('journal_id',$row->id)
        //                              ->whereDate('created_at','<',date('Y-m-d'))
        //                              ->latest()
        //                              ->first();
  
        //         $exists = Versions::where('journal_id',$row->id)
        //         ->where('year',date('Y'))
        //         ->where('month',date('m'))
        //         ->where('day',date('d'))
        //         ->firstOrCreate([
        //             'version' => $next_version_name,
        //             'year' => date('Y'),
        //             'month' =>  date('m'),
        //             'journal_id' => $row->id,
        //             'day' =>  date('d')   
        //         ]);
      
        //         $last_version_publish_date = date('Y-m-d',strtotime($last_version->year.'-'.(array_search($last_version->month,$this->months)+1).'-'.$last_version->day));
              
        //         if($last_version_publish_date){
        //           $paid_researches_invoices = Invoices::whereNotNull('paid_at')
        //                                               ->whereBetween(DB::raw('DATE(paid_at)'), array($last_version_publish_date, date('Y-m-d')))
        //                                               ->where('payment_response','1')
        //                                               ->where('journal_id',$row->id)
        //                                               ->pluck('users_researches_id')
        //                                               ->toArray();
                                               
        //           foreach ($paid_researches_invoices as $research_id) {
        //             $user_research = UsersResearches::with('user')->find($research_id);
        //             if($user_research)
        //             {
        //                 $journal_research = new JournalsResearches;
        //                 $journal_research->title =  $user_research->title;
        //                 $journal_research->slug = Str::slug($user_research->title);
        //                 $journal_research->abstract = $user_research->abstract;
        //                 $journal_research->author_name = $user_research->user->name;
        //                 $journal_research->file = $user_research->file;
        //                 $journal_research->keywords = $user_research->keywords;
        //                 $journal_research->journal_id = $user_research->journal_id;
        //                 $journal_research->version_id = $exists->id;
        //                 $journal_research->save();
        //             }

        //           }
                 
        //         //   JournalsResearches::whereBetween(DB::raw('DATE(created_at)'), array($last_version_publish_date, date('Y-m-d')))
        //         //                       ->where('journal_id',$row->id)
        //         //                       ->update(['version_id'=>$exists->id]);
        //         }
        //         DB::table($journals_db->table)->where("slug", $slug)->update(['next_version_name'=>'']);
            
        // }
        if(strtotime($row->next_version)){
            $year = explode('-',$row->next_version)[0];
            $day = explode('-',$row->next_version)[2];
            $month =   explode('-',$row->next_version)[1];
            
            if((int)$month != 0){
                $month =  (int)( explode('-',$row->next_version)[1]) - 1 ;
            }
            $final_date = $day." ".$this->months[$month]." ".$year;

            $row->next_version = $final_date;
        }
        // //fill the versions array 
        // $decimals_names=['عشر','العشرون','الثلاثون','الأربعون','الخمسون','الستون','السبعون','الثمانون','التسعون'];
        // for($i =12;$i<=100;$i++){
        //     $decimal_digit = (int)((string)$i)[0];
        //     $single_digits = (int)((string)$i)[1];
        //     if($single_digits !== 0){
        //         if($decimal_digit == 1 )
        //         {
        //         array_push($this->versions,($this->versions[$single_digits].' '. $decimals_names[$decimal_digit - 1]));
        //         }
        //         else
        //         {
        //         array_push($this->versions,($this->versions[$single_digits].' و '. $decimals_names[$decimal_digit - 1]));
        //         }
        //     }else{
        //         array_push($this->versions,($decimals_names[$decimal_digit - 1]));
        //     }
        // }
    
        //if the next version is today we should publish a new version researches
       
        $months_names = $this->months;
        $latest_journals = DB::table($journals_db->table)->limit(3)->get();
        return view("main.journals.show", compact('row', "team", "internationalCredits", "versions", "services", "latest_journals","months_names"));
    }
    private function checkJournal($slug)
    {
        return Journals::where("slug", $slug)->first();
    }
    public function versions(Versions $versions_db, $slug)
    {
        $row = $this->checkJournal($slug);
        if (empty($row)) {
            return redirect('journals');
        }
        $versions = Versions::with(['research' => function ($q) {
            $q->select('version_id');
        }])->where("journal_id", $row->id)->orderBy('id', 'DESC')->get();

        if(strtotime($row->next_version)){
            $year = explode('-',$row['next_version'])[0];
            $day = explode('-',$row['next_version'])[2];
            $month =   explode('-',$row['next_version'])[1];
            
            if((int)$month != 0){
                $month =  (int)( explode('-',$row['next_version'])[1]) - 1 ;
            }
            $final_date = $day." ".$this->months[$month]." ".$year;

            $row['next_version'] = $final_date;
        }
        $months_names = $this->months;
        return view("main.journals.versions", compact("versions", 'row','months_names'));
    }
    public function team($slug)
    {
        $row = $this->checkJournal($slug);
        if (empty($row)) {
            return redirect('journals');
        }
        $team = Team::where("journal_id", $row->id)->orderBy('id', 'DESC')->get();
        return view("main.journals.team", compact("team", 'row'));
    }
    public function publication_ethics($slug)
    {
        $row = $this->checkJournal($slug);
        if (empty($row)) {
            return redirect('journals');
        }
        return view("main.journals.publication-ethics", compact('row'));
    }
    public function how_to_submit_the_article($slug)
    {
        $row = $this->checkJournal($slug);
        if (empty($row)) {
            return redirect('journals');
        }
        return view("main.journals.how-to-submit-the-article", compact('row'));
    }
    public function publication_price($slug)
    {
        $row = $this->checkJournal($slug);
        if (empty($row)) {
            return redirect('journals');
        }
        return view("main.journals.publication-price", compact('row'));
    }
    public function reviewers_instructions($slug)
    {
        $row = $this->checkJournal($slug);
        if (empty($row)) {
            return redirect('journals');
        }
        return view("main.journals.reviewers-instructions", compact('row'));
    }
    public function authors_instructions($slug)
    {
        $row = $this->checkJournal($slug);
        if (empty($row)) {
            return redirect('journals');
        }
        return view("main.journals.authors-instructions", compact('row'));
    }
    public function international_credits($slug)
    {
        $row = $this->checkJournal($slug);
        if (empty($row)) {
            return redirect('journals');
        }
        $credits = InternationalCredits::where("journal_id", $row->id)->orderBy('id', 'DESC')->get();
        return view("main.journals.international-credits", compact('row', 'credits'));
    }
}
