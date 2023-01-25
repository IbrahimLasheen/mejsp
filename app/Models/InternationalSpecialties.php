<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InternationalSpecialties extends Model
{
    use HasFactory;

    
    public $guarded = [];   
    public $table = 'international_specialties';
    public $timestamps = false;


    public function type()
    {
        return $this->belongsTo(InternationalTypes::class,'type_id','id');
    }

}
