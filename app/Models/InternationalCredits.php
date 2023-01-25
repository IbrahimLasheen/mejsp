<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InternationalCredits extends Model
{
    use HasFactory;

    public $guarded = [];   
    public $table = 'international_credits';
    public $timestamps = false;


    
    public function journal()
    {
        return $this->belongsTo(Journals::class,'journal_id','id');
    }

}
