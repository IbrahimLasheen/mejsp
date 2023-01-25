<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;
    public $table   = 'chats';
    public $guarded = [];
    
    protected $filable=[
        'research_id'
        ];


    public function message()
    {
        return $this->hasMany(Message::class, 'user_id', 'id');
    }
    
    public function resrearch()
    {
        return $this->hasOne(UsersResearches::class, 'id', 'research_id');
    }
    
}
