<?php

use App\Http\Controllers\authcontroller;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\VerificationController;
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
Route::post('register',[authcontroller::class,'createUser'])->middleware('guest');
Route::group(['middleware'=>'auth:sanctum'],function(){
    Route::post('send-message',[ChatController::class,'send']);
    Route::post('recive_message',[ChatController::class,'recive_message']);
    Route::post('read_message',[ChatController::class,'read_message']);
});


Route::post('email/verfification-notification',[EmailVerificationController::class,'sendVerificationEmail'])->middleware('auth:sanctum');
Route::get('verify-email/{id}/{hash}',[EmailVerificationController::class,'verify'])->name('verification.verify')->middleware('auth:sanctum');
Route::get('email/resend', [EmailVerificationController::class,'resend'])->name('verification.resend');
