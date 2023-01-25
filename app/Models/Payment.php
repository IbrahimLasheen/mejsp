<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;


    public $table   = 'payments';
    public $guarded = [];



    public function user()
    {
        return $this->belongsTo(User::class, 'payment_by', 'id');
    }

    public function conf()
    {
        return $this->belongsTo(Conferences::class, 'for_conference', 'id');
    }


    public function intr()
    {
        return $this->belongsTo(InternationalPublicationOrders::class, 'for_international_publishing', 'id');
    }


    
    public function research()
    {
        return $this->belongsTo(JournalsResearches::class, 'for_research', 'id');
    }

    public function invoice()
    {
        return $this->belongsTo(Invoices::class, 'for_invoice', 'id');
    }


}
