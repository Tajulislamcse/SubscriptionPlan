<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login',[AuthController::class,'showLoginForm'])->name('login');
Route::post('/login',[AuthController::class,'login'])->name('login.submit');
Route::get('/register',[AuthController::class,'showRegisterForm'])->name('register');
Route::post('/register',[AuthController::class,'register'])->name('register.submit');
Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'emailVerify'])->name('verification.verify')->middleware('signed');



