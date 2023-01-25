<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JournalsResearches extends Model
{
    use HasFactory;


    public $table = 'journals_researches';
    public $guarded = [];


    public function journal()
    {
        return $this->belongsTo(Journals::class,'journal_id','id');
    }


    public function version()
    {
        return $this->belongsTo(Versions::class,'version_id','id');
    }

}
