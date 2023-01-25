<?php

namespace App\Http\Controllers;

use App\Models\Articles;
use App\Models\Journals;
use App\Models\JournalsResearches;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{

    public function index(Journals $journals_db, Articles $articles_db)
    {
        // Get Journals
        $journals = DB::table($journals_db->table)->orderBy("id", "DESC")->get();

        // Get Articles
        $articles = DB::table($articles_db->table)->orderBy("id", "DESC")->limit(6)->get();


        return view("main.home", compact("journals", "articles"));
    }



    public function search()
    {
        $q = request('q');

        $query = null;
        $where = null;
        $equal = '=';

        if (isset($_GET['q'])) {
            $query = "%" . trim($q) . "%";
            $where = 'title';
            $equal = 'like';
        }

        $rows = JournalsResearches::with(['journal' => function ($t) {
            $t->select("id", 'name');
        }])->where($where, $equal, $query)->orderBy("id", 'DESC')->paginate(100);
        return view('main.search', compact("rows"));
    }
}
