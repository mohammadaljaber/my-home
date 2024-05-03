<?php

use App\Http\Controllers\authcontroller;
use App\Http\Controllers\ChatController;

use App\Http\Controllers\HouseController;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\PasswordResetController;
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

Route::post('login',[authcontroller::class,'login']);
Route::group(['middleware'=>'auth:sanctum'],function(){
    Route::post('send-message',[ChatController::class,'send']);
    Route::get('receive_message/{id}',[ChatController::class,'receive_message']);
    Route::get('read_message/{id}',[ChatController::class,'read_message']);
    Route::post('get_houses',[HouseController::class,'get_houses']);
    Route::put('house/update/{id}',[HouseController::class,'update']);
    Route::get('house/info/{id}',[HouseController::class,'house_info']);
});

