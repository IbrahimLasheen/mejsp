<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dev extends Model
{
    use HasFactory;
    public $table = 'dev';
    public $timestamps = false;
    public $connection = "mysql2";
}
