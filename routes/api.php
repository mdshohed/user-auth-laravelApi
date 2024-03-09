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
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/registration', [UserController::class, "UserRegistration"]);
Route::post('/login', [UserController::class, "UserLogin"]);
Route::post('/send-otp', [UserController::class, "SendOTPCode"]);
Route::post('/verify-otp', [UserController::class, "VerifyOTP"]);
// token verify 
Route::post('/reset-password', [UserController::class, "ResetPassword"])
        ->middleware([TokenVerificationMiddleware::class]);