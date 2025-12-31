<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BannerController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\NewsLetterController;
use App\Http\Controllers\Api\AuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/send-otp', [AuthController::class, 'sendOtp']);
Route::post('/verify-otp', [AuthController::class, 'verifyOtp']);

//Get Banner list
Route::get('/banners', [BannerController::class, 'index']);

//Contact Form Submission
Route::post('/contact-submit', [ContactController::class, 'index']);

//Newsletter Subscription
Route::post('/newsletter-subscribe', [NewsLetterController::class, 'subscribe']);
    