<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function houses(){
        return $this->belongsToMany(House::class,'house_property','property_id','house_id')
        ->withPivot('value')
        ->withTimestamps();
    }
    
}
