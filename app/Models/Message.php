<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    public $table   = 'messages';
    public $guarded = [];
    
    protected $filable=[
        'chat_id',
        'user_id',
        'message',
        'file'
        ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'user_id');
    }
    
    public function chat()
    {
        return $this->belongsTo(Chat::class, 'id', 'chat_id');
    }
    
}
