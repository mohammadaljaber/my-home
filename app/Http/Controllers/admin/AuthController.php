<?php

namespace App\Http\Controllers\admin;

use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(LoginRequest $request){
        $data=$request->validated();
        if(!Auth::attempt($data))
            return back()->withErrors('error','invalid data');
        
        return auth()->user();
    }
}
