<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class EmailVerificationController extends Controller
{
    public function sendVerificationEmail(Request $request){
        if($request->$this->user()->hasVerifiedEmail()){
            return[
                'message'=>'Aleready verified',
            ];
        }
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


    public function resend() {
        if (auth()->user()->hasVerifiedEmail()) {
            return response()->json(["msg" => "Email already verified."], 400);
        }
    
        auth()->user()->sendEmailVerificationNotification();
    
        return response()->json(["msg" => "Email verification link sent on your email id"]);
    }
}
