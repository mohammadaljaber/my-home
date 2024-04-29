<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class EmailVerificationController extends Controller
{
    public function sendVerificationEmail(Request $request){
        // if($request->$this->user()->hasVerifiedEmail()){
        //     return[
        //         'message'=>'Aleready verified',
        //     ];
        // }
        $request->user()->sendEmailVerificationNotification();

        return ['status' => 'verification code sent'];
    }

    public function verify(EmailVerificationRequest $request){
        if($request->user()->hasVerifiedEmail()){
            return[
                'message'=>'Aleready verified',
            ];
        }
        if($request->user()->markEmailAsVerified()){
            event(new Verified($request->user()));
        }
        return[
            'message'=>'Email has been verified'
        ];
    }
    
    
    
    // // public function verify(Request $request,$user_id){
    // //     if(!$request->hasValidSignature()){
    // //         return response()->json(["msg"=> "Invalid/Expire url provided.",401]);
    // //     }

    // //     $user = User::findOrFail($user_id);

    // //     if(!$user->hasVerifiedEmail()){
    // //         $user->markEmailAsVerified();
    // //     }

    // //     return redirect()->to('/');
    // // }


    public function resend() {
        if (auth()->user()->hasVerifiedEmail()) {
            return response()->json(["msg" => "Email already verified."], 400);
        }
    
        auth()->user()->sendEmailVerificationNotification();
    
        return response()->json(["msg" => "Email verification link sent on your email id"]);
    }
}
