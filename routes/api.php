<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Middleware\TokenVerificationMiddleware;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware gro]\up. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// api routes
Route::post('/registration', [UserController::class, "UserRegistration"]);
Route::post('/login', [UserController::class, "UserLogin"]);
Route::post('/logout', [UserController::class, "UserLogout"]);
Route::post('/send-otp', [UserController::class, "SendOTPCode"]);
Route::post('/verify-otp', [UserController::class, "VerifyOTP"]);
Route::post('/reset-password', [UserController::class, "ResetPassword"])->middleware([TokenVerificationMiddleware::class]);

Route::get('/profile', [UserController::class, "UserProfile"])->middleware([TokenVerificationMiddleware::class]);
Route::post('/update-profile', [UserController::class, "UpdateProfile"])->middleware([TokenVerificationMiddleware::class]);

// page routes
Route::get('userLogin', [UserController::class, 'LoginPage']);
Route::get('userRegistration', [UserController::class, 'RegistrationPage']);
Route::get('sendOtp', [UserController::class, 'sendOtpPage']);
Route::get('verifyOtp', [UserController::class, 'verifyOtpPage']);
Route::get('resetPassword', [UserController::class, 'resetPasswordPage']);
// Route::get('dashboard', [UserController::class, 'dashboardPage']);
