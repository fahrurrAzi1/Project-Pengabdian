<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;

// halaman home
Route::get('/',[HomeController::class, 'index']);

// halaman registrasi
Route::get('registration', [AuthController::class, 'registration']);
Route::post('registration_post', [AuthController::class, 'registration_post']);

// login
Route::get('login', [AuthController::class, 'login']);
Route::post('login_post', [AuthController::class, 'login_post']);

// forgot
Route::get('forgot', [AuthController::class, 'forgot']);

Route::group(['middleware' => 'admin'], function(){

});

Route::group(['middleware' => 'guru'], function(){
    
});

Route::group(['middleware' => 'siswa'], function(){
    
});

// Route::get('/', function () {
//     return view('welcome');
// });
