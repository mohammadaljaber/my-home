<?php

namespace App\Livewire\User;

use App\Models\User;
use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        $active_user=User::where('status',1)->count();
        $banded_user=User::where('status',0)->count();
        $users=User::get();
        return view('livewire.user.index',compact('active_user','banded_user','users'))
        ->extends('layouts.main') 
        ->section('body');
    }
}
