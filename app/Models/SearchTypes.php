<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SearchTypes extends Model
{
    use HasFactory;
    public $table   = 'search_types';
    public $guarded = [];
}
