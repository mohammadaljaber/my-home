<?php

namespace App\Livewire\House;

use App\Models\House;
use Livewire\Component;
class Houses extends Component
{

    public $type,$search;

    public function render()
    {
        $houses_count=House::count();
        $houses=House::when($this->type,fn($q)=>
            $q->where('is_for_sale',$this->type))
        ->when($this->search,function($q){
            $q->whereHas('user',function($q){
                $q->where('email','like','%'.$this->search.'%');
            });
        })
        ->get();
        return view('livewire.house.houses',
        compact('houses','houses_count'))
        ->extends('layouts.main') 
        ->section('body');
    }
}
