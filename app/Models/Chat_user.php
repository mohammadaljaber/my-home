<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat_user extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function sender(){
        return $this->belongsTo(User::class,'sender_id','id');
    }
    public function reciver(){
        return $this->belongsTo(User::class,'reciver_id','id');
    }
}
