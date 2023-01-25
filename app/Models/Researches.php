<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Researches extends Model
{
    use HasFactory;
    public $table   = 'researches';
    public $guarded = [];
}
