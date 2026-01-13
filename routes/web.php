<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\AssetClassController;
use App\Http\Controllers\Admin\TypeController;
use App\Http\Controllers\Admin\StrategieController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\RiskRatingController;
use App\Http\Controllers\Admin\FirmController;
use App\Http\Controllers\Admin\FundController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\ImportJobController;
use App\Http\Controllers\Admin\ImportJobRowController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\NewsLetterController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\AuthUserController;
use App\Http\Controllers\Admin\OurValueController;
use App\Http\Controllers\Admin\WebPageController;
use App\Http\Controllers\Admin\SubscriptionController;
use App\Http\Controllers\Admin\AccessRuleController;
use App\Http\Controllers\Admin\PlanAccessController;
use Illuminate\Support\Facades\Artisan;

Route::get('/', function () {
    return view('welcome');
});



Route::get('/run-storage-link', function () {
    Artisan::call('storage:link');
    return 'Storage link created successfully!';
});


// Route::get('dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');


Route::prefix('admin')->name('admin.')->group(function () {    
        Route::get('/login', [AuthController::class, 'index'])->name('login');
        Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
   
    Route::middleware('auth:admin')->group(function () {
        Route::get('dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('profile', [AuthController::class, 'profile'])->name('profile');
        Route::post('profile', [AuthController::class, 'updateProfile'])->name('profile.update');
        Route::get('change-password', [AuthController::class, 'changePassword'])->name('password.change');
        Route::post('change-password', [AuthController::class, 'updatePassword'])->name('password.update');  
        
        
        /*---------------------------------Asset Class Controller ---------------------------------------------*/
        Route::prefix('asset-class')->name('asset.class.')->group(function () {
            Route::get('/list', [AssetClassController::class, 'index'])->name('list');
            Route::get('/add', [AssetClassController::class, 'create'])->name('create');
            Route::post('/create', [AssetClassController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [AssetClassController::class, 'edit'])->name('edit');
            Route::post('/update/{id}', [AssetClassController::class, 'update'])->name('update');
            Route::delete('/destroy/{id}', [AssetClassController::class, 'destroy'])->name('destroy');
        });
        /*---------------------------------End Asset Class Controller -----------------------------------------*/

        /*---------------------------------Type Controller ----------------------------------------------------*/
        Route::prefix('type')->name('type.')->group(function () {
            Route::get('/list', [TypeController::class, 'index'])->name('list');
            Route::get('/add', [TypeController::class, 'create'])->name('create');
            Route::post('/create', [TypeController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [TypeController::class, 'edit'])->name('edit');
            Route::post('/update/{id}', [TypeController::class, 'update'])->name('update');
            Route::delete('/destroy/{id}', [TypeController::class, 'destroy'])->name('destroy');
        });
        /*---------------------------------End Type Controller -----------------------------------------------*/

        /*---------------------------------Strategy Controller -----------------------------------------------*/
        Route::prefix('strategie')->name('strategie.')->group(function () {
            Route::get('/list', [StrategieController::class, 'index'])->name('list');
            Route::get('/add', [StrategieController::class, 'create'])->name('create');
            Route::post('/create', [StrategieController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [StrategieController::class, 'edit'])->name('edit');
            Route::post('/update/{id}', [StrategieController::class, 'update'])->name('update');
            Route::delete('/destroy/{id}', [StrategieController::class, 'destroy'])->name('destroy');
        });
        /*---------------------------------End Strategy Controller -------------------------------------------*/

        /*---------------------------------Category Controller -----------------------------------------------*/
        Route::prefix('category')->name('category.')->group(function () {
            Route::get('/list', [CategoryController::class, 'index'])->name('list');
            Route::get('/add', [CategoryController::class, 'create'])->name('create');
            Route::post('/create', [CategoryController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [CategoryController::class, 'edit'])->name('edit');
            Route::post('/update/{id}', [CategoryController::class, 'update'])->name('update');
            Route::delete('/destroy/{id}', [CategoryController::class, 'destroy'])->name('destroy');
        });
        /*---------------------------------End Category Controller -------------------------------------------*/

        /*---------------------------------RiskRating Controller ---------------------------------------------*/
        Route::prefix('risk-rating')->name('risk.rating.')->group(function () {
            Route::get('/list', [RiskRatingController::class, 'index'])->name('list');
            Route::get('/add', [RiskRatingController::class, 'create'])->name('create');
            Route::post('/create', [RiskRatingController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [RiskRatingController::class, 'edit'])->name('edit');
            Route::post('/update/{id}', [RiskRatingController::class, 'update'])->name('update');
            Route::delete('/destroy/{id}', [RiskRatingController::class, 'destroy'])->name('destroy');
        });
        /*---------------------------------End RiskRating Controller -----------------------------------------*/

        /*---------------------------------Firm Controller----------------------------------------------------*/
        Route::prefix('firm')->name('firms.')->group(function () {
            Route::get('/list', [FirmController::class, 'index'])->name('list');
            Route::get('/add', [FirmController::class, 'create'])->name('create');
            Route::post('/create', [FirmController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [FirmController::class, 'edit'])->name('edit');
            Route::put('/update/{id}', [FirmController::class, 'update'])->name('update');
            Route::delete('/destroy/{id}', [FirmController::class, 'destroy'])->name('destroy');
        });
        /*---------------------------------End Firm Controller------------------------------------------------*/

        /*---------------------------------Fund Controller----------------------------------------------------*/
        Route::prefix('fund')->name('funds.')->group(function () {
            Route::get('/list', [FundController::class, 'index'])->name('list');
            Route::get('/add', [FundController::class, 'create'])->name('create');
            Route::post('/create', [FundController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [FundController::class, 'edit'])->name('edit');
            Route::put('/update/{id}', [FundController::class, 'update'])->name('update');
            Route::delete('/destroy/{id}', [FundController::class, 'destroy'])->name('destroy');
            Route::get('/view/{id}', [FundController::class, 'show'])->name('view');
        });
        /*---------------------------------End Fund Controller------------------------------------------------*/

        /*---------------------------------Page Controller----------------------------------------------------*/
        Route::prefix('page')->name('pages.')->group(function () {
            Route::get('/list', [PageController::class,'index'])->name('list');
            Route::get('/add', [PageController::class,'create'])->name('create');
            Route::post('/store', [PageController::class,'store'])->name('store');
            Route::get('/edit/{id}', [PageController::class,'edit'])->name('edit');
            Route::put('/update/{id}', [PageController::class,'update'])->name('update');
            Route::delete('/destroy/{id}', [PageController::class,'destroy'])->name('destroy');
            Route::get('/view/{id}', [PageController::class,'show'])->name('show');
        });
        /*---------------------------------End Page Controller------------------------------------------------*/

        /*---------------------------------User Management Controller-----------------------------------------*/
        Route::prefix('user-management')->name('users.')->group(function () {
            Route::get('/list', [UserManagementController::class,'index'])->name('list');
            Route::get('/add', [UserManagementController::class,'create'])->name('create');
            Route::post('/store', [UserManagementController::class,'store'])->name('store');
            Route::get('/edit/{id}', [UserManagementController::class,'edit'])->name('edit');
            Route::put('/update/{id}', [UserManagementController::class,'update'])->name('update');
            Route::delete('/destroy/{id}', [UserManagementController::class,'destroy'])->name('destroy');
            Route::get('/view/{id}', [UserManagementController::class,'show'])->name('show');
        });
        /*---------------------------------End User Management Controller-------------------------------------*/

        /*---------------------------------Import Job Controller----------------------------------------------*/
        Route::prefix('import-jobs')->name('import-jobs.')->group(function () {
            Route::get('/', [ImportJobController::class,'index'])->name('list');
            Route::get('/create', [ImportJobController::class,'create'])->name('create');
            Route::post('/store', [ImportJobController::class,'store'])->name('store');
            Route::delete('/destroy/{id}', [ImportJobController::class,'destroy'])->name('destroy');
            Route::get('/view/{id}', [ImportJobController::class,'show'])->name('show');
        });
        /*---------------------------------End Import Job Controller------------------------------------------*/

        /*---------------------------------Import Job Controller----------------------------------------------*/
        Route::prefix('import-job-rows')->name('import-job-rows.')->group(function(){
            Route::get('/',[ImportJobRowController::class,'index'])->name('list');
            Route::get('/view/{id}',[ImportJobRowController::class,'show'])->name('show');
        });
        /*---------------------------------End Import Job Controller------------------------------------------*/

        /*---------------------------------Banner Controller--------------------------------------------------*/
        Route::prefix('banner')->name('banner.')->group(function () {
            Route::get('/list', [BannerController::class,'index'])->name('list');
            Route::get('/add', [BannerController::class,'create'])->name('create');
            Route::post('/store', [BannerController::class,'store'])->name('store');
            Route::get('/edit/{id}', [BannerController::class,'edit'])->name('edit');
            Route::put('/update/{id}', [BannerController::class,'update'])->name('update');
            Route::delete('/destroy/{id}', [BannerController::class,'destroy'])->name('destroy');
            Route::get('/view/{id}', [BannerController::class,'show'])->name('show');
        });
        /*---------------------------------End Banner Controller---------------------------------------------*/

        /*---------------------------------Contact Controller------------------------------------------------*/
        Route::prefix('contact-us')->name('contact.')->group(function () {
            Route::get('/list', [ContactController::class,'index'])->name('list');            
            Route::delete('/destroy/{id}', [ContactController::class,'destroy'])->name('destroy');
            Route::get('/view/{id}', [ContactController::class,'show'])->name('show');
        });
        /*---------------------------------End Contact Controller--------------------------------------------*/

        /*---------------------------------NewsLetter Controller---------------------------------------------*/
        Route::prefix('newsletter-subscribe')->name('newsletter-subscribe.')->group(function () {
            Route::get('/list', [NewsLetterController::class,'index'])->name('list');            
            Route::delete('/destroy/{id}', [NewsLetterController::class,'destroy'])->name('destroy');
        });
        /*---------------------------------End NewsLetter Controller-----------------------------------------*/

        /*---------------------------------Setting Controller ------------------------------------------------*/
        Route::prefix('settings')->name('settings.')->group(function () {
            Route::get('/', [SettingController::class, 'index'])->name('edit');
            Route::post('settings/update', [SettingController::class, 'update'])->name('update');
        });
        /*---------------------------------End Setting Controller--------------------------------------------*/

        /*---------------------------------BlogController----------------------------------------------------*/
         Route::prefix('bolg')->name('blog.')->group(function () {
            Route::get('/list', [BlogController::class,'index'])->name('list');
            Route::get('/add', [BlogController::class,'create'])->name('create');
            Route::post('/store', [BlogController::class,'store'])->name('store');
            Route::get('/edit/{id}', [BlogController::class,'edit'])->name('edit');
            Route::post('/update/{id}', [BlogController::class,'update'])->name('update');
            Route::delete('/destroy/{id}', [BlogController::class,'destroy'])->name('destroy');
            Route::get('/view/{id}', [BlogController::class,'show'])->name('show');
        });
        /*---------------------------------End BlogController------------------------------------------------*/

        /*---------------------------------Auth User Controller----------------------------------------------*/
         Route::prefix('auth-user')->name('auth.user.')->group(function () {
            Route::get('/list', [AuthUserController::class,'index'])->name('list');            
            Route::delete('/destroy/{id}', [AuthUserController::class,'destroy'])->name('destroy');
        });
        /*---------------------------------End Auth User Controller------------------------------------------*/

        /*---------------------------------Our Value Controller----------------------------------------------*/
         Route::prefix('our-value')->name('value.')->group(function () {
            Route::get('/list', [OurValueController::class,'index'])->name('list');
            Route::get('/add', [OurValueController::class,'create'])->name('create');
            Route::post('/store', [OurValueController::class,'store'])->name('store');
            Route::get('/edit/{id}', [OurValueController::class,'edit'])->name('edit');
            Route::post('/update/{id}', [OurValueController::class,'update'])->name('update');
            Route::delete('/destroy/{id}', [OurValueController::class,'destroy'])->name('destroy');
            Route::get('/view/{id}', [OurValueController::class,'show'])->name('show');
        });
        /*---------------------------------End Our Value Controller------------------------------------------*/

        /*---------------------------------Web Page Controller-----------------------------------------------*/
         Route::prefix('web-pages')->name('web.page.')->group(function () {
            Route::get('/list', [WebPageController::class,'index'])->name('list');
            Route::get('/add', [WebPageController::class,'create'])->name('create');
            Route::post('/store', [WebPageController::class,'store'])->name('store');
            Route::get('/edit/{id}', [WebPageController::class,'edit'])->name('edit');
            Route::post('/update/{id}', [WebPageController::class,'update'])->name('update');
            Route::delete('/destroy/{id}', [WebPageController::class,'destroy'])->name('destroy');
        });
        /*---------------------------------End Web Page Controller-------------------------------------------*/

        /*---------------------------------Subscription Controller-------------------------------------------*/
        Route::prefix('subscription')->name('subscriptions.')->group(function () {
            Route::get('/list', [SubscriptionController::class, 'index'])->name('list');
            Route::get('/add', [SubscriptionController::class, 'create'])->name('create');
            Route::post('/create', [SubscriptionController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [SubscriptionController::class, 'edit'])->name('edit');
            Route::put('/update/{id}', [SubscriptionController::class, 'update'])->name('update');
            Route::delete('/destroy/{id}', [SubscriptionController::class, 'destroy'])->name('destroy');
            Route::get('/view/{id}', [SubscriptionController::class,'show'])->name('show');

        });
        /*---------------------------------End Subscription Controller--------------------------------------*/

        /*---------------------------------Access Rule Controller-------------------------------------------*/
        Route::prefix('access-rule')->name('access.rule.')->group(function () {
            Route::get('/list', [AccessRuleController::class, 'index'])->name('list');
            Route::get('/add', [AccessRuleController::class, 'create'])->name('create');
            Route::post('/create', [AccessRuleController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [AccessRuleController::class, 'edit'])->name('edit');
            Route::put('/update/{id}', [AccessRuleController::class, 'update'])->name('update');
            Route::delete('/destroy/{id}', [AccessRuleController::class, 'destroy'])->name('destroy');
            Route::get('/view/{id}', [AccessRuleController::class,'show'])->name('show');
        });
        /*---------------------------------End Access Rule Controller--------------------------------------*/

        /*---------------------------------Plan Access Controller------------------------------------------*/
        Route::prefix('plan-access')->name('plan.access.')->group(function () {
            Route::get('/list', [PlanAccessController::class, 'index'])->name('list');
            Route::get('/add', [PlanAccessController::class, 'create'])->name('create');
            Route::post('/create', [PlanAccessController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [PlanAccessController::class, 'edit'])->name('edit');
            Route::put('/update/{id}', [PlanAccessController::class, 'update'])->name('update');
            Route::delete('/destroy/{id}', [PlanAccessController::class, 'destroy'])->name('destroy');
            Route::get('/view/{id}', [PlanAccessController::class,'show'])->name('show');
        });
        /*---------------------------------End Plan Access Controller--------------------------------------*/

    });
}); 