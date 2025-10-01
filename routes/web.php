<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DataController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SubscriptionController;

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
Route::get('/data', [DataController::class, 'index'])->name('data');
Route::get('/checkout/{plan}', [CheckoutController::class, 'index'])->name('checkout');
Route::get('/checkout/process/{plan}', [CheckoutController::class, 'process'])->name('checkout.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::group(['middleware' => ['auth', 'prevent-back-history', 'verified']], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});
Route::prefix('admin')->name('admin.')->group(function () {
    // Admin login routes
    Route::get('/login', [AuthController::class, 'showAdminLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'adminLogin'])->name('login.submit');
    Route::resource('settings', SettingsController::class)->only(['index', 'store']);

    // Protected admin routes
    Route::middleware(['auth:admin', 'prevent-back-history'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/users', [AdminController::class, 'users'])->name('users.index');
        Route::resource('plans', PlanController::class);
        Route::get('/subscriptions', [SubscriptionController::class, 'index'])->name('subscriptions.index');
        Route::post('/logout', [AdminController::class, 'logout'])->name('logout');
    });
});

