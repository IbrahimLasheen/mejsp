<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceItems extends Model
{
    use HasFactory;

    public $guarded = [];   
    public $table = 'invoice_items';

}
