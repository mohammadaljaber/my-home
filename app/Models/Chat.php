<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function chat_user(){
        return $this->hasOne(Chat_user::class,'chat_id','id');
    }
    public function messages(){
        return $this->hasMany(Message::class,'chat_id','id');
    }
}
