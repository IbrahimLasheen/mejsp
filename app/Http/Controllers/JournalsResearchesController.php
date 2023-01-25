<?php

namespace App\Http\Controllers;

use App\Models\Journals;
use App\Models\Services;
use App\Models\Versions;
use Illuminate\Http\Request;
use App\Models\JournalsResearches;
use Illuminate\Support\Facades\DB;

class JournalsResearchesController extends Controller
{
    const PATH = "assets/uploads/journals-researches/";
    const ALLOWED_EXT = '.pdf';
    public $months = ["يناير", "فبراير", "مارس", "أبريل", "مايو", "يونيو", "يوليو", "أغسطس", "سبتمبر", "أكتوبر", "نوفمبر", "ديسمبر"];

    private function rules($request, $type = ['store', 'update'], $uniqueId = null)
    {
        $checkField = $type == "update" ? "nullable" : "required";
        $uniqueId = $uniqueId != null ? "," . $uniqueId : $uniqueId;
        $ids = DB::table('journals')->select('id')->get();
        $journalsIDs = [];
        foreach ($ids as $row) {
            array_push($journalsIDs, $row->id);
        }
        $request->validate(['title' => $checkField . '|max:255|unique:journals_researches,title' . $uniqueId, 'author_name' => $checkField . '|max:255', 'file' => 'nullable|mimes:pdf', 'abstract' => $checkField, 'price' => 'nullable|digits_between:2,5|numeric', 'journal' => $checkField . "|in:" . implode(",", $journalsIDs), 'version' => $checkField, 'keywords_final' => 'nullable|max:3000', 'keywords' => 'nullable|max:3000']);
    }
    public function index()
    {
        $pageTitle = 'الابحاث';
        $column = null;
        $where = null;
        $operator = '=';
        $value = null;
        $version_column = null;
        $version_value = null;
        $title_param = isset($_GET['title']) ? trim($_GET['title']) : '';
        $journal_param = isset($_GET['journal']) ? intval($_GET['journal']) : 0;
        $version_param = isset($_GET['version']) ? intval($_GET['version']) : 0;
        if (!empty($title_param) && !empty($version_param)) {
            $version_column = 'version_id';
            $version_value = $version_param;
            $column = 'title';
            $value = "%" . $title_param . "%";
            $operator = 'like';
        } elseif (!empty($title_param)) {
            $column = 'title';
            $value = "%" . $title_param . "%";
            $operator = 'like';
        } elseif (!empty($version_param)) {
            $version_column = 'version_id';
            $version_value = $version_param;
        }
        $versions = [];
        if (!empty($journal_param)) {
            $versions = Versions::orderBy("id", "DESC")->where("journal_id", $journal_param)->get();
        }
        $researches = JournalsResearches::with(['journal' => function ($q) {
            $q->select("name", 'id');
        }, 'version'])->where($column, $operator, $value)->where($version_column, $version_value)->paginate(100);
        $journals = Journals::orderBy("id", "DESC")->select("name", "id")->get();
        return view("admin.journals-researches.all", compact('pageTitle', "researches", 'journals', 'versions'));
    }
    public function create()
    {
        $pageTitle = 'اضافة بحث جديد';
        $journals = Journals::orderBy("id", "DESC")->select("name", "id")->get();
        return view("admin.journals-researches.create", compact('pageTitle', "journals"));
    }
    public function store(Request $request)
    {

        $this->rules($request);
        $file = $request->file ?? null;
        $fileName = $request->file ? randomName() . '.pdf' : null;
        $keywords=$request->keywords_final ? $request->keywords_final : $request->keywords;
        $insert = JournalsResearches::create(['title' => $request->title, 'slug' => slug($request->title), "author_name" => $request->author_name, 'file' => $fileName, 'abstract' => $request->abstract, 'price' => $request->price, 'journal_id' => $request->journal, 'version_id' => $request->version,'keywords'=>$keywords]);
        if ($insert->save()) {
            if ($request->file) {
                move_uploaded_file($file->getRealPath(), public_path(self::PATH . $fileName));
            }
            return response(['status' => true, 'message' => 'تم اضافة البحث بنجاح', "form" => 'reset']);
        }
    }
    public function edit($id)
    {
        $row = JournalsResearches::find($id);
        if (!empty($row)) {
            $pageTitle = 'تعديل بحث';
            $journals = Journals::orderBy("id", "DESC")->select("name", "id")->get();
            $versions = Versions::select('id', 'version', "year", "old_version", "day", "month")->where("journal_id", $row->journal_id)->orderBy('id', 'DESC')->get();
            return view("admin.journals-researches.edit", compact('pageTitle', "journals", 'row', 'versions'));
        } else {
            return redirect(adminUrl(""));
        }
    }
    public function update(Request $request)
    {
        $id = $request->id;
        $journalsResearches = JournalsResearches::where("id", $id);
        $row = $journalsResearches->first();
        if (!empty($row)) {
            $this->rules($request, 'update', $id);
            $fileName = $row->file;
            if ($request->hasFile('file')) {
                $file = $request->file;
                $fileName = randomName() . '.pdf';
                deleteFile(self::PATH, $row->file);
            }
            $keywords = $request->keywords_final ? $request->keywords_final : $request->keywords;

            $update = $journalsResearches->update(['title' => $request->title, 'slug' => slug($request->title), "author_name" => $request->author_name, 'file' => $fileName, 'abstract' => $request->abstract, 'price' => $request->price, 'journal_id' => $request->journal, 'version_id' => $request->version,'keywords'=>$keywords]);
            if ($update > 0) {
                if ($request->hasFile('file')) {
                    move_uploaded_file($file->getRealPath(), public_path(self::PATH . $fileName));
                }
                return response(['status' => true, 'message' => 'تم تحديث البحث بنجاح',]);
            }
        } else {
            return response(['status' => "notfound", 'message' => 'هذه البيانات ليست موجود في النظام']);
        }
    }
    public function destroy(Request $request)
    {
        $row = JournalsResearches::find($request->id);
        if (!empty($row)) {
            @unlink(self::PATH . $row->file);
            $row->delete();
            $request->session()->flash('deleteMessage', 'تم حذف البيانات بنجاح');
            return back();
        }
        return back();
    }
    public function researches(JournalsResearches $research_db, $slug, $version_id)
    {
        $pageTitle = '';
        $row = Versions::where('id', $version_id)->first();
        if (empty($row)) {
            return redirect('');
        }
        if ($row->old_version != null) {
            $pageTitle = $row->old_version . ' من ' . unSlug($slug);
        } else {
            $month = (int)($row->month) ;
            if($month != 0){
                $month =  (int)($row->month) - 1 ;
            }
            $pageTitle = "الإصدار " . $row->version . ' : ' . $row->day . ' ' . $this->months[$month] . ' ' . $row->year . ' ' . ' من ' . unSlug($slug);
        }
        $query = null;
        $where = null;
        $equal = '=';
        if (isset($_GET['search'])) {
            $query = "%" . trim($_GET['search']) . "%";
            $where = 'title';
            $equal = 'like';
        }
        $researches = DB::table($research_db->table)->where("version_id", $version_id)->where($where, $equal, $query)->orderBy('id', 'ASC')->get();
        $journals = Journals::orderBy("id", "DESC")->limit(6)->select('name', 'slug', 'cover')->get();
        $services = Services::orderBy("id", "DESC")->get();
        $months = $this->months;
        return view('main.journals-researches.researches', compact('pageTitle', 'researches', 'row', 'slug', 'journals', 'services','months'));
    }
    public function show($slug)
    {
        $row = JournalsResearches::with(["journal" => function ($q) {
            $q->select('id', 'name');
        }, "version"])->where('slug', $slug)->first();
        if (empty($row)) {
            return redirect('');
        }
        $pageTitle = $row->title;
        $journals = Journals::orderBy("id", "DESC")->limit(3)->select('name', 'slug', 'cover', 'meta_desc')->get();
        $services = Services::orderBy("id", "DESC")->get();
        $months = $this->months;
        return view('main.journals-researches.show', compact('pageTitle', 'row', 'journals', 'services','months'));
    }
}
