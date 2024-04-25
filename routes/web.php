<?php

use App\Http\Controllers\admin\AuthController;
use App\Http\Controllers\admin\UserController;
use App\Livewire\User\Index;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('Auth.login');
});
Route::post('admin/login',[AuthController::class,'login'])->name('login');
Route::middleware('admin')->group(function(){
    Route::get('admin/dashboard',[AuthController::class,'dashboard'])->name('dashboard');
    // Route::get('admin/user',[UserController::class,'index'])->name('user');
    Route::get('admin/user',Index::class)->name('user');
});

