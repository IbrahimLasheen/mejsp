<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Journals extends Model
{
    use HasFactory;

    public $table   = 'journals';
    public $guarded = [];

    public function vers()
    {
       // return $this->
    }

    public function Invoices() {
        return $this->hasMany(Invoices::class, 'journal_id', 'id');
    }


}
