<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InternationalJournals extends Model
{
    use HasFactory;

    
    public $guarded = [];   
    public $table = 'international_journals';
    public $timestamps = false;


    public function specialty()
    {
        return $this->belongsTo(InternationalSpecialties::class,'specialty_id','id');
    }

}
