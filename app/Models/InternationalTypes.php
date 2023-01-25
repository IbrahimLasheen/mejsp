<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InternationalTypes extends Model
{
    use HasFactory;

    
    public $guarded = [];   
    public $table = 'international_types';
    public $timestamps = false;

    

}
