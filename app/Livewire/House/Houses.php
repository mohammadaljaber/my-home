<?php

namespace App\Livewire\House;

use Livewire\Component;

class Houses extends Component
{
    public function render()
    {
        return view('livewire.house.houses')
        ->extends('layouts.main') 
        ->section('body');
    }
}
