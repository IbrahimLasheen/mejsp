<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoices extends Model
{
    use HasFactory;

    public $guarded = [];   
    public $table = 'invoices';
    public $timestamps = false;

    public static function boot() {
        parent::boot();
    
        //while creating/inserting item into db  
        static::updated(function (Invoices $invoice) {
            if($invoice->payment_response != 0 || $invoice->payment_response != '0')
            {
                $invoice->paid_at = now();
                $invoice->save(); 
             }
        });
    }

    public function items()
    {
        return $this->hasMany(InvoiceItems::class,'invoice_id','id');
    }
    public function journal () {
        return $this->belongsTo(Journals::class, 'journal_id', 'id');
    }


}
