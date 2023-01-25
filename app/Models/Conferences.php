<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conferences extends Model
{
    use HasFactory;
    public $guarded = [];
    public $table = 'conferences';


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function confCategory()
    {
        return $this->belongsTo(ConferenceCategories::class, 'category', 'id');
    }
    

}
