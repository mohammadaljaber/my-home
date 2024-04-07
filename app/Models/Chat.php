<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function f_user(){
        return $this->belongsTo(User::class,'f_user','id');
    }
    public function s_user(){
        return $this->belongsTo(User::class,'s_user','id');
    }
    public function messages(){
        return $this->hasMany(Message::class,'chat_id','id');
    }
}
