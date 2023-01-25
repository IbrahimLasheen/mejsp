<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersResearches extends Model
{
    use HasFactory;
    public $table   = 'users_researches';
    public $guarded = [];


    public function journal()
    {
        return $this->belongsTo(Journals::class, 'journal_id', 'id');
    }
    
    public function chat()
    {
        return $this->belongsTo(Chat::class, 'research_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function invoice() {
        return $this->hasOne(Invoices::class, 'users_researches_id', 'id');
    }
    public function unpaidinvoice(){
        return $this->invoice()->where('payment_response',0);
    }
}
