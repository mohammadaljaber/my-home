<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class house_proprety extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function proprety(){
        return $this->belongsTo(Property::class,'proprety_id','id');
    }
}
