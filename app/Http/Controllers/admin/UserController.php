<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;

class UserController extends Controller
{
    public function index(){
        // return url()->previous();
        $active_user=User::where('status',1)->count();
        $banded_user=User::where('status',0)->count();
        $users=User::get();
        
        return view('Admin.users',compact('active_user','banded_user','users'));
    }
}
