<?php

use App\Http\Controllers\authcontroller;
use App\Http\Controllers\ChatController;
<<<<<<< HEAD
use App\Http\Controllers\HouseController;
=======
use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\VerificationController;
>>>>>>> 3f8a982fd5929890dc2e1b7d5b951894b2d21930
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum','verified')->get('/user',function(Request $request){
    return $request->user();
});

Route::post('login',[authcontroller::class,'login']);
Route::post('logout',[authcontroller::class,'logout'])->middleware('auth:sanctum');
Route::post('register',[authcontroller::class,'createUser'])->middleware('guest');
Route::group(['middleware'=>'auth:sanctum'],function(){
    Route::post('send-message',[ChatController::class,'send']);
    Route::get('receive_message/{id}',[ChatController::class,'receive_message']);
    Route::get('read_message/{id}',[ChatController::class,'read_message']);
    Route::post('get_houses',[HouseController::class,'get_houses']);
    Route::put('house/update/{id}',[HouseController::class,'update']);
    Route::get('house/info/{id}',[HouseController::class,'house_info']);
});

<<<<<<< HEAD
=======

Route::post('email/verfification-notification',[EmailVerificationController::class,'sendVerificationEmail'])->middleware('auth:sanctum');
Route::get('verify-email/{id}/{hash}',[EmailVerificationController::class,'verify'])->name('verification.verify')->middleware('auth:sanctum');
Route::get('email/resend', [EmailVerificationController::class,'resend'])->name('verification.resend');

///////////

//password reset routes

Route::post('forgot-password',[PasswordResetController::class,'sendpasswordlink']);
Route::post('Reset-password',[PasswordResetController::class,'reset']);
>>>>>>> 3f8a982fd5929890dc2e1b7d5b951894b2d21930
