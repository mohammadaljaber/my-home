<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class House_property extends Model
{
    use HasFactory;
    protected $guarded=[];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
    
    }

