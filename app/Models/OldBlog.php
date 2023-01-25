<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OldBlog extends Model
{
    use HasFactory;

    public $table   = 'old_blog';
    public $guarded = [];
}
