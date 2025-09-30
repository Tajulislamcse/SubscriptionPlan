<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

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
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::group(['middleware' => ['auth', 'prevent-back-history', 'verified']], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});
Route::prefix('admin')->name('admin.')->group(function () {
    // Admin login routes
    Route::get('/login', [AuthController::class, 'showAdminLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'adminLogin'])->name('login.submit');
    
    // Protected admin routes
    Route::middleware(['auth:admin', 'prevent-back-history'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/users', [AdminController::class, 'users'])->name('users.index');
        Route::get('/subscriptions', [SubscriptionController::class, 'index'])->name('subscriptions.index');
        Route::post('/logout', [AdminController::class, 'logout'])->name('logout');
    });
});

