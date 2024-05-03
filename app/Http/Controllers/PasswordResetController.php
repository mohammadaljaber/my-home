<?php

namespace App\Http\Controllers;

use App\Models\User;
use Dotenv\Exception\ValidationException;
use Dotenv\Validator;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class PasswordResetController extends Controller
{
    public function sendpasswordlink(Request $request){
        $request->validate([
            'email' => 'required|email|exists:users',
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if($status == Password::RESET_LINK_SENT){
            return [
                'status' => __($status),
            ];
        }

        throw ValidationException::withMessages([
            'email' => [trans($status)],
        ]);
    }

    public function reset(Request $request){
        $request -> validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email','password','password_confirmation','token'),
            function($user) use ($request){
                $user->forceFill([
                    'password' =>Hash::make($request->password),
                    'remember_token'=>Str::random(60),
                ])->save();
                $user->tokens()->delete();

                event(new PasswordReset($user));
            }


        );

        if($status == Password::PASSWORD_RESET){
            
            return response()->json([
                'message' => 'Password reset completed',
                'status' => '200',
            ],200);
        }

        return response([
            'message' => __($status),
        ],500);
    }
}
