<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BannerController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\NewsLetterController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\SettingController;
use App\Http\Controllers\Api\BlogController;


Route::post('/send-otp', [AuthController::class, 'sendOtp']);
Route::post('/verify-otp', [AuthController::class, 'verifyOtp']);

//Get Banner list
Route::get('/banners', [BannerController::class, 'index']);

//Contact Form Submission
Route::post('/contact-submit', [ContactController::class, 'index']);

//Newsletter Subscription
Route::post('/add-subscribe', [NewsLetterController::class, 'subscribe']);

//Get Settings
Route::get('/settings', [SettingController::class, 'index']);

//Get Blogs
Route::get('blogs', [BlogController::class, 'list']);
Route::get('blogs/{slug}', [BlogController::class, 'details']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profile', [AuthController::class,'profile']);
    Route::post('/profile-update', [AuthController::class,'updateProfile']);
    Route::post('/logout', [AuthController::class,'logout']);
    Route::post('/delete-account', [AuthController::class, 'deleteAccount']);
});
