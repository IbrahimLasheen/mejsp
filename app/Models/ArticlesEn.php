<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticlesEn extends Model
{
    use HasFactory;

    public $guarded = [];   
    public $table = 'articles_en';

}
