<?php

namespace App\Models;

use App\Enums\ownership_type;
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
    protected $casts = [
        'ownership_type' =>ownership_type::class ,
    ];

}
