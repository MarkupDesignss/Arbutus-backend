<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BannerController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\NewsLetterController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\SettingController;
use App\Http\Controllers\Api\BlogController;
use App\Http\Controllers\Api\OurValueController;
use App\Http\Controllers\Api\WebPageController;
use App\Http\Controllers\Api\PageController;
use App\Http\Controllers\Api\SubscriptionController;
use App\Http\Controllers\Api\SubscriptionPurchaseController;
use App\Http\Controllers\Api\AssetClassController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\StrategyController;
use App\Http\Controllers\Api\TypeController;
use App\Http\Controllers\Api\FundController;
use App\Http\Controllers\Api\SponsorsController;


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

//Get Our Values
Route::get('our-values', [OurValueController::class, 'list']);
Route::get('our-values/{id}', [OurValueController::class, 'details']);

//Get Web Pages
Route::get('web-pages', [WebPageController::class, 'list']);

//Get single page by slug
Route::get('pages/{slug}', [PageController::class, 'index']);

//Get Subscriptions
Route::get('subscriptions', [SubscriptionController::class, 'index']);
Route::get('subscriptions/{id}', [SubscriptionController::class, 'show']);

//Get Asset Classes
Route::get('asset-classes', [AssetClassController::class, 'index']);

//Get Categories
Route::get('categories', [CategoryController::class, 'index']);

//Get Strategies
Route::get('strategies', [StrategyController::class, 'index']);

//Get Types
Route::get('types', [TypeController::class, 'index']);

//Get Funds
Route::get('funds', [FundController::class, 'index']);
Route::get('filter-funds', [FundController::class, 'filterData']);

//Sponsors 
Route::get('sponsors-list', [SponsorsController::class, 'index']);

// Protected Routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profile', [AuthController::class,'profile']);
    Route::post('/profile-update', [AuthController::class,'updateProfile']);
    Route::post('/logout', [AuthController::class,'logout']);
    Route::post('/delete-account', [AuthController::class, 'deleteAccount']);
    //SUBSCRIPTION PURCHASE API
    // Route::post('/subscribe-payment', [SubscriptionPurchaseController::class,'subscribe']);
    Route::post('/subscribe-payment', [SubscriptionPurchaseController::class,'subscribe']);
    // Route::get('/payment-success', [SubscriptionPurchaseController::class,'success']);
});

Route::get('/payment-success', [SubscriptionPurchaseController::class,'success']);

Route::post('/stripe/webhook', [SubscriptionPurchaseController::class,'stripeWebhook']);