<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceJournal extends Model
{
    use HasFactory;

    public $guarded = [];   
    public $table = 'invoice_journals';
    public function items()
    {
        return $this->hasMany(InvoiceJournalItem::class,'invoice_journal_id','id');
    }
    public function journal () {
        return $this->belongsTo(Journals::class, 'journal_id', 'id');
    }

}
