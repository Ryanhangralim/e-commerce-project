<?php

use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MailController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashboardController;
use Database\Seeders\SellerApplicationSeeder;
use App\Http\Controllers\GenerateReportController;
use App\Http\Controllers\SellerApplicationController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

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
    Route::get('/login', [LoginController::class, 'loginForm'])
    ->name('login');
    Route::post('/login', [LoginController::class, 'authenticate'])
    ->name('authenticate');

    // Register related routes
    Route::get('/register', [RegisterController::class, 'registerForm'])
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

    // Profile related routes
    Route::get('/profile', [ProfileController::class, 'viewProfile'])
    ->name('view-profile');

    Route::post('/profile/update-profile-picture', [ProfileController::class, 'updateProfilePicture'])
    ->name('profile.update-profile-picture');
});

// Customer middleware
Route::middleware('role:customer')->group(function (){
    Route::get('/seller-application', [SellerApplicationController::class, 'applicationForm'])
    ->name('apply-seller');
    Route::post('/seller-application', [SellerApplicationController::class, 'store'])
    ->name('application-form');
});


// Seller middleware
Route::prefix('/seller/dashboard')->middleware('role:seller')->group(function(){
    Route::get('/', [DashboardController::class, 'dashboard'])
    ->name('seller-dashboard');

    // Product related routes
    Route::get('/product', [ProductController::class, 'viewProduct'])
    ->name('view-product');

    Route::get('/product/{product:id}', [ProductController::class, 'productDetail'])
    ->name('product-detail');

    Route::post('/product/{product:id}/add-stock', [ProductController::class, 'addStock'])
    ->name('product.add-stock');

    Route::post('/product/{product:id}/set-discount', [ProductController::class, 'setDiscount'])
    ->name('product.set-discount');
});

// Admin middleware
Route::prefix('/admin/dashboard')->middleware('role:admin')->group(function (){
    Route::get('/', [DashboardController::class, 'dashboard'])
    ->name('admin-dashboard');

    // User related routes
    Route::get('/user', [UserController::class, 'viewUser'])
    ->name('dashboard.user');

    Route::post('/user', [UserController::class, 'updateRole'])
    ->name('dashboard.update-role');

    Route::get('/user/fetch-users', [UserController::class, 'fetchUsers'])
    ->name('dashboard.fetch-users');
    
    Route::get('/user/generate-user-report', [GenerateReportController::class, 'generateUserReport'])
    ->name('dashboard.generate-user-report');


    // Seller application related routes
    Route::get('/seller-application', [SellerApplicationController::class, 'viewSellerApplication'])
    ->name('dashboard.seller-application');

    Route::post('/verify-seller-application', [SellerApplicationController::class, 'verify'])
    ->name('dashboard.verify-seller');

    Route::post('/reject-seller-application', [SellerApplicationController::class, 'reject'])
    ->name('dashboard.reject-seller');

    Route::get('/seller-application/fetch-application',  [SellerApplicationController::class, 'fetchApplications'])
    ->name('dashboard.fetch-applications');

    // Business related routes
    Route::get('/business', [BusinessController::class, 'viewBusiness'])
    ->name('dashboard.business');
});

// Business related routes
Route::prefix('/business')->group(function(){
    Route::get('/{business:slug}', [BusinessController::class, 'main'])
    ->name('business');
});