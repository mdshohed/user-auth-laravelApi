<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\TokenVerificationMiddleware;
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
    return view('welcome');
});
// api routes
Route::post('/registration', [UserController::class, "UserRegistration"]);
Route::post('/login', [UserController::class, "UserLogin"]);
Route::get('/logout', [UserController::class, "UserLogout"]);
Route::post('/send-otp', [UserController::class, "SendOTPCode"]);
Route::post('/verify-otp', [UserController::class, "VerifyOTP"]);
Route::post('/reset-password', [UserController::class, "ResetPassword"])->middleware([TokenVerificationMiddleware::class]);

Route::get('/profile', [UserController::class, "UserProfile"])->middleware([TokenVerificationMiddleware::class]);
Route::post('/update-profile', [UserController::class, "UpdateProfile"])->middleware([TokenVerificationMiddleware::class]);

// user logout
// Route::get('/logout', [UserController::class, 'UserLogout']);

// page routes
Route::get('/userLogin', [UserController::class, 'LoginPage']);
Route::get('/userRegistration', [UserController::class, 'RegistrationPage']);
Route::get('/sendOtp', [UserController::class, 'sendOtpPage']);
Route::get('/verifyOtp', [UserController::class, 'verifyOtpPage']);
Route::get('/resetPassword', [UserController::class, 'resetPasswordPage']);
Route::get('/dashboard', [DashboardController::class, 'DashboardPage']);
