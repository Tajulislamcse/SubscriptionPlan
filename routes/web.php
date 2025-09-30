<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login',[AuthController::class,'showLoginForm'])->name('login');
Route::post('/login',[AuthController::class,'login'])->name('login.submit');
Route::get('/register',[AuthController::class,'showRegisterForm'])->name('register');
Route::post('/register',[AuthController::class,'register'])->name('register.submit');
Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'emailVerify'])->name('verification.verify')->middleware('signed');
Route::get('/otp/verify', function () {
    return view('verify-otp');
})->name('otp.verify.form');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/otp/verify', [AuthController::class, 'verifyOtp'])->name('otp.verify');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/data', [DataController::class, 'index'])->name('data');
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


