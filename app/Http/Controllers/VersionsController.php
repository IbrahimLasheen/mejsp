<?php

namespace App\Http\Controllers;

use App\Models\Journals;
use App\Models\Versions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class VersionsController extends Controller
{

    public $months = ["يناير", "فبراير", "مارس", "أبريل", "مايو", "يونيو", "يوليو", "أغسطس", "سبتمبر", "أكتوبر", "نوفمبر", "ديسمبر"];


    private function rules($request)
    {


        $years  = date('Y') . "," . date('Y') + 1 . "," . date('Y') + 2 . "," . date('Y') + 3 . "," . date('Y') + 4 . "," . date('Y') + 5;

        $ids = DB::table('journals')->select('id')->get();

        $journalsIDs = [];

        foreach ($ids as $row) {
            array_push($journalsIDs, $row->id);
        }

        // Validate
        $request->validate([
            'month'        => "required|in:" . implode(',', $this->months),
            'day'          => 'required|digits_between:1,31|numeric|min:1|max:31',
            'year'         => 'required|in:' . $years,
            'version'      => 'required|max:255',
            'journals'     => "required|in:" . implode(",", $journalsIDs),
        ]);
        
    }


    public function index(Versions $db)
    {
        // Page Title
        $pageTitle  = "الاصدارات";
        $buttonText = "اضافة الإصدار";
        $buttonStyle = "btn-main";
        $formUrl = adminUrl("versions/store");

        // Fetch All Journals
        $journals = Journals::orderBy("id", 'DESC')->select("id", "name")->get();

        // Fetch All Versions
        $versions =  $db->with('journal')->orderBy("id", 'DESC')->paginate(25);

        $count_old_version =  $db->whereNotNull("old_version")->count();


        // Pass Months To View 
        $months = $this->months;
        // Get Request
        $do   = isset($_GET['do']) ? $_GET['do'] : NULL;
        $type = isset($_GET['type']) ? $_GET['type'] : NULL;
        $id   = isset($_GET['id']) ? $_GET['id'] : 0;

        $editRow = NULL;

        if ($do == "edit") {
            $editRow = $db->find($id);
            if((int)$editRow->month ==0){
                $editRow->month = $this->months[0];
            }else{
                $editRow->month = $this->months[(int)$editRow->month -1];   
            }
            $buttonText = 'تحديث';
            $buttonStyle = 'btn btn-success';
            $formUrl = adminUrl("versions/update");
            if (empty($editRow)) {
                return  redirect(adminUrl("versions"));
            }
        }
        $months_names = $this->months;
        return view("admin.versions.versions", compact("count_old_version", "pageTitle", "versions", "journals", "editRow", "months", "buttonText", 'buttonStyle', 'formUrl','months_names'));
    }

    public function store(Request $request)
    {

        // Check
        $row = Versions::where('version', $request->version)->where('year', $request->year)->where('month', $request->month)->where('day', $request->day)->where('journal_id', $request->journals)->first();

        if (empty($row)) {


            $this->rules($request);
            
            $insert = Versions::create([
                'version' => $request->version,
                'year' => $request->year,
                'month' => $request->month,
                'journal_id' => $request->journals,
                'day' => $request->day
            ]);

            if ($insert->save()) {
                return response([
                    'status'  => true,
                    'message' => 'تم اضافة الاصدار بنجاح',
                    "form"    => 'reset'
                ]);
            }
        } else {
            return response([
                'status'  => 'alert',
                'message' => 'لقد تم اضافة نفس الاصدار من قبل لنفس المجلة',
            ]);
        }
    }


    public function update(Request $request)
    {
        $row = Versions::where('version', $request->version)->where('year', $request->year)->where('month', $request->month)->where('day', $request->day)->where('journal_id', $request->journals)->first();

        if (empty($row)) {
            $this->rules($request);

            $row = Versions::find($request->id);
            if (!empty($row)) {


                $row->version = $request->version;
                $row->year = $request->year;
                $row->month = $request->month;
                $row->journal_id = $request->journals;
                $row->day = $request->day;
                $row->old_version = NULL;

                if ($row->save()) {
                    return response([
                        'status'  => true,
                        'message' => 'تم تحديث الاصدار بنجاح',
                    ]);
                }
            } else {

                return response([
                    'notfound'  => true,
                ]);
            }
        } else {
            return response([
                'status'  => 'alert',
                'message' => 'لقد تم اضافة نفس الاصدار من قبل لنفس المجلة',
            ]);
        }
    }

    public function destroy(Request $request)
    {
        try {
            $id = Crypt::decryptString($request->id);
            $row = Versions::find($id);
            if (!empty($row)) {
                $row->delete();
                $request->session()->flash('statusMsg', 'تم حذف الاصدار بنجاح');
            }
        } catch (DecryptException $e) {
            return back();
        }
        return back();
    }



    // API
    public function get_version_api($id)
    {
        // Get Target For Messages Send
        $versions = Versions::select('id', 'version', "year", "old_version", "day", "month")->where("journal_id", $id)->orderBy('id', 'DESC')->get();

        $versions = json_decode($versions);
        return $versions;
    }
}
