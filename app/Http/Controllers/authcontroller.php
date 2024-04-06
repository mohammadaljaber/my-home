<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class authcontroller extends Controller
{
    public function login(Request $request){

        if(User::where('email',$request->email)->first()){
            $data=$request->only('email','password');
            if(Auth::attempt($data)){
                $user=Auth::user();
                $user->tokens()->delete();
                $token = $user->createToken('apiToken')->plainTextToken;
                // $token1=$user->createToken('test')->accessToken; 
                return response()->json(['token'=>$token,'user'=>$user],404);
            }else{
                return response()->json(['message'=>'this password uncorrect'], 401);
            }

        }else{
            return response()->json(['message'=>'this user not found'], 200);
        }
        
    }
}
