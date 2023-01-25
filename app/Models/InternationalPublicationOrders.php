<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InternationalPublicationOrders extends Model
{
    use HasFactory;

    public $guarded = [];   
    public $table = 'international_publication_orders';


    public function journal()
    {
        return $this->belongsTo(InternationalJournals::class,'journal_id','id');
    }


    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

}
