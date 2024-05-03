<?php

namespace App\Http\Controllers;

use App\Models\User;
//use Dotenv\Validator;
use Illuminate\Auth\Events\Validated;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use App\Notifications\EmailVerifictionNotification;

//use Illuminate\Foundation\Auth\User;



class authcontroller extends Controller
{

    public function createUser(Request $request){

        $validateUser = Validator::make($request->all(),[
            'first_name' => 'required|string|max:10',
            'last_name' => 'required|string|max:10',
            'long_loc' => 'required',
            'lat_loc' => 'required',
            'email' => 'required|email|unique:users,email',
            'role'=>'required',
            'password' => 'required|min:3|confirmed',
            

        ]);
        
        if($validateUser->fails()){
            return response()->json([
                'status' => false,
                'messsage' => 'validation error',
                'error' => $validateUser->errors()
            ],401);
        }

        $user = User::create([
            'first_name'=> $request->first_name,
            'last_name' => $request->last_name,
            'long_loc' => $request->long_loc,
            'lat_loc' => $request->lat_loc,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);
        event(new Registered($user));
        $user->notify(new EmailVerifictionNotification());
        return response()->json([
            'status' => 'true',
            'message' => 'User created successfuly',
            'token' => $user->createToken("API TOKEN")->plainTextToken
        ],200);

        
    }
////////////////////////////////////////////////////////////////



    public function login(Request $request){

        if(User::where('email',$request->email)->first()){
            $data=$request->only('email','password');
            if(Auth::attempt($data)){
                $user=Auth::user();
                $user->tokens()->delete();
                $token = $user->createToken('apiToken')->plainTextToken;
                return response()->json(['token'=>$token,'user'=>$user],200);
            }else{
                return response()->json(['message'=>'this password uncorrect'], 401);
            }

        }else{
            return response()->json(['message'=>'this user not found'], 404);
        }
        
    }
    //////////////////////////////////////////////////////
    public function logout(Request $request){
        $request->user()->tokens()->delete();

        return response()->json([
            'status' => 'true',
            'message' => 'Logout successfully',
        ],200);
    }

}
