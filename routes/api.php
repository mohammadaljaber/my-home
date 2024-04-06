<?php

use App\Http\Controllers\authcontroller;
use App\Http\Controllers\ChatController;
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
});
