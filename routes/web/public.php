<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminAuth\ForgotPasswordController;
use App\Http\Controllers\AdminAuth\ResetPasswordController;
use App\Http\Controllers\AdminAuth\AdminLoginController;
use App\Http\Controllers\AdminAuth\RegisterController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\AnnouncementsController;
use App\Http\Controllers\FacultyController;
use App\Http\Controllers\FacultyExportController;
use App\Http\Controllers\GuestAccountController;
use App\Http\Controllers\GuestAccountExportController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IMRADController;
use App\Http\Controllers\ImradExportController;
use App\Http\Controllers\ImradMetricController;
use App\Http\Controllers\InvalidAdminController;
use App\Http\Controllers\InvalidFacultyController;
use App\Http\Controllers\InvalidUserController;
use App\Http\Controllers\LogHistoryController;
use App\Http\Controllers\LogHistoryExportController;
use App\Http\Controllers\MyLibraryController;
use App\Http\Controllers\PreferenceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SendEmailController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\TrashBinController;
use App\Http\Controllers\UserAuth\UserForgotPasswordController;
use App\Http\Controllers\UserAuth\UserLoginController;
use App\Http\Controllers\UserAuth\UserResetController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserExportController;
// ======================= Super Admin Verification Route ================================
Route::get('login/superadmin/verify', [SuperAdminController::class, 'showVerifyForm'])->name('superadmin.verify');
Route::post('login/super_admin/verify_code', [SuperAdminController::class, 'verify_code'])->name('superadmin.verify.code');

// ======================= Admin Verification Route ================================
Route::get('login/admin/verify', [AdminAuthController::class, 'adminVerifyForm'])->name('admin.verify');
Route::post('login/admin/verify_code', [AdminAuthController::class, 'adminVerifyCode'])->name('admin.verify.code');

// ======================= Landing Page Route ================================
Route::get('/', [AdminLoginController::class, 'landingPage'])->name('landing.page');

Route::middleware('guest')->group(function () {

    Route::get('guest/filter', [GuestController::class, 'filterFiles'])->name('guest.filter');

    Route::get('guest/FAQ', [HomeController::class,'viewFAQ'])->name('faq.display');
    Route::get('guest/about', [HomeController::class,'viewAbout'])->name('about.display');
    Route::get('guest/e-resources', [HomeController::class,'viewEresources'])->name('eresources.display');


    Route::get('guest/{imrad}', [GuestController::class, 'viewFile'])->name('guest.view.file');
    Route::get('guest', [GuestController::class, 'index'])->name('guest.page');
    Route::get('guest/announcement/{announcement}', [AnnouncementController::class, 'viewAnnouncement'])->name('guest.view.announcement');
});

Route::get('/login/{userType}', [UserLoginController::class, 'showLoginForm'])
    ->where('userType', 'admin|superadmin')
    ->name('login');

Route::post('/login/{userType}', [UserLoginController::class, 'login'])
    ->where('userType', 'admin|superadmin')
    ->name('login.submit');

Route::get('/index', [UserLoginController::class, 'alreadyLoggedIn'])->name('already.logged.in');

Route::post('logout', [UserLoginController::class, 'logout'])->name('logout');
Route::get('/verify-email/user/{user_code}', [UserLoginController::class, 'verifyEmail'])->name('verify.email');
Route::get('/verify-email/admin/{user_code}', [AdminLoginController::class, 'verifyEmail'])->name('verify.email.admin');
Route::get('/verify-email/guest/{user_code}', [GuestAccountController::class, 'verifyEmail'])->name('verify.email.guest');
Route::get('admin/reset/verification', [UserLoginController::class,'resendAdminLogin'])->name('admin.resend.verification.request');
Route::get('superadmin/reset/verification', [UserLoginController::class,'resendSuperadminLogin'])->name('superadmin.resend.verification.request');


Route::get('password/reset', [UserForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [UserForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [UserResetController::class, 'showResetForm'])->name('password.reset');
Route::post('/password/reset', [UserResetController::class, 'reset'])->name('password.update');

// count users donwload
Route::post('/update-downloads/{imradID}', [ImradMetricController::class, 'updateDownloads'])->name('update.downloads');
Route::post('/update-views/{imradID}', [ImradMetricController::class, 'updateViews'])->name('update.views');
