<?php

namespace App\Livewire\User;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $page,$search;


    public function render()
    {
        
        $active_user=User::where('status',1)->count();
        $banded_user=User::where('status',0)->count();
        $users=User::where('email','like','%'.$this->search.'%')->paginate($this->page ?? 5);
        
        return view('livewire.user.index'
        ,compact('active_user','banded_user','users'))
        ->extends('layouts.main') 
        ->section('body');
    }
}
