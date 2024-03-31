<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class House extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function images(){
        return $this->hasMany(Image::class,'house_id','id');
    }
    public function propreties(){
        return $this->belongsToMany(Property::class,'house_proprety','house_id')
        ->withPivot('value')
        ->withTimestamps();
    }
}
