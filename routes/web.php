<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MailController;
use App\Http\Controllers\RegisterController;
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
})->middleware('auth')->name('home');

Route::get('/login', [LoginController::class, 'index'])
->name('login');

Route::post('/login', [LoginController::class, 'authenticate'])
->name('authenticate');

Route::post('/logout', [LogoutController::class, 'logout'])
->name('logout');

// Register related routes
Route::get('/register', [RegisterController::class, 'index'])
->name('register');
Route::post('/register', [RegisterController::class, 'store'])
->name('add_new_user');

// Email Verification related routes
Route::get('/email/verify', [MailController::class, 'verificationNotice'])
->middleware('auth')
->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', [MailController::class, 'verificationHandler'])
->middleware(['auth', 'signed'])
->name('verification.verify');

Route::post('/email/verification-notification', [MailController::class, 'resendVerificationEmail'])
->middleware(['auth', 'throttle:6,1'])
->name('verification.send');