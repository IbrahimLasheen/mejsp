<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConferenceCategories extends Model
{
    use HasFactory;

    public $guarded = [];   
    public $table = 'conference_categories';

}
