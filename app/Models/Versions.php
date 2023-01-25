<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Versions extends Model
{
    use HasFactory;

    public $table   = 'versions';
    public $guarded = [];


    public function journal()
    {
        return $this->belongsTo(Journals::class, 'journal_id', 'id');
    }


    public function research()
    {
        return $this->hasMany(JournalsResearches::class, 'version_id', 'id');
    }

}
