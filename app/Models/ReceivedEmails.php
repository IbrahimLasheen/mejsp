<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReceivedEmails extends Model
{
    use HasFactory;

    public $table   = 'received_emails';
    public $guarded = [];
    
}
