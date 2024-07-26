<?php

use App\Http\Controllers\GenerateReportController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MailController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SellerApplicationController;
use App\Http\Controllers\UserController;
use Database\Seeders\SellerApplicationSeeder;
use GuzzleHttp\Psr7\Request;

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
    return view('welcome');
})->middleware('role:customer,admin,seller')->name('home');


// Guest middleware
Route::middleware('guest')->group(function (){
    // Login related routes
    Route::get('/login', [LoginController::class, 'index'])
    ->name('login');
    Route::post('/login', [LoginController::class, 'authenticate'])
    ->name('authenticate');

    // Register related routes
    Route::get('/register', [RegisterController::class, 'index'])
    ->name('register');
    Route::post('/register', [RegisterController::class, 'store'])
    ->name('add_new_user');

    // Password reset related routes
    Route::get('/forgot-password', [PasswordController::class, 'forgotPasswordForm'])
    ->name('password.request');
    Route::post('/forgot-password', [PasswordController::class, 'validateEmail'])
    ->name('password.email');
    Route::get('/reset-password/{token}', [PasswordController::class, 'resetPasswordForm'])
    ->name('password.reset');
    Route::post('/reset-password', [PasswordController::class, 'resetPassword'])
    ->name('password.update');
});


// Auth middleware
Route::middleware('auth')->group(function (){
    Route::post('/logout', [LogoutController::class, 'logout'])
    ->name('logout');
    // Email Verification related routes
    Route::get('/email/verify', [MailController::class, 'verificationNotice'])
    ->name('verification.notice');
    
    Route::get('/email/verify/{id}/{hash}', [MailController::class, 'verificationHandler'])
    ->middleware('signed')
    ->name('verification.verify');
    
    Route::post('/email/verification-notification', [MailController::class, 'resendVerificationEmail'])
    ->middleware('throttle:6,1')
    ->name('verification.send');
});

// Customer middleware
Route::middleware('role:customer')->group(function (){
    Route::get('/seller-application', [SellerApplicationController::class, 'index'])
    ->name('apply-seller');
    Route::post('/seller-application', [SellerApplicationController::class, 'store'])
    ->name('application-form');
});

// Admin middleware
Route::middleware('role:admin')->group(function (){
    Route::get('/dashboard', function () {
        return view('dashboard.index');
    })
    ->name('dashboard');

    Route::get('/dashboard/user', [UserController::class, 'index'])
    ->name('dashboard.user');

    Route::get('/dashboard/user/generate-user-report', [GenerateReportController::class, 'generateUserReport'])
    ->name('dashboard.generate-user-report');

    // Seller application related routes
    Route::get('/dashboard/seller-application', [SellerApplicationController::class, 'view'])
    ->name('dashboard.seller-application');

    Route::post('/dashboard/verify-seller-application', [SellerApplicationController::class, 'verify'])
    ->name('dashboard.verify-seller');

    Route::post('/dashboard/reject-seller-application', [SellerApplicationController::class, 'reject'])
    ->name('dashboard.reject-seller');

    Route::get('/dashboard/fetch-application',  [SellerApplicationController::class, 'fetchApplication'])
    ->name('dashboard.fetch-application');
});