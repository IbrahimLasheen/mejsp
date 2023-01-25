<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    use HasFactory;

    public $table   = 'settings';
    public $guarded = [];
    public $timestamps = false;
    protected $casts=['sections_status'=>'array'];
}
