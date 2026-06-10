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
Route::get('guest/account/login', [GuestAccountController::class, 'showLoginForm'])->name('guest.account.login');
Route::post('guest/account/login', [GuestAccountController::class, 'login'])->name('guest.account.login.submit');
Route::get('guest/account/register', [GuestAccountController::class, 'showRegistrationForm'])->name('guest.account.register');
Route::post('guest/account/register', [GuestAccountController::class, 'register'])->name('guest.account.register.submit');
Route::post('guest/account/logout', [GuestAccountController::class, 'logout'])->name('guest.account.logout');

// ======================= Page for unauthenticated users Route ================================
Route::get('/guest/auth/google', [GuestAccountController::class, 'googleLogin'])->name('guest.auth.google');
Route::get('guest/auth/google/call-back', [GuestAccountController::class, 'callbackGoogle'])->name('guest.auth.call-back');

Route::post('guest/send/email', [SendEmailController::class,'sendEmail'])->name('guest.send.email');


Route::middleware(['auth:guest_account', 'role:guest'])->group(function () {
    Route::get('guest/account/home/preference', [PreferenceController::class, 'view'])->name('guest.account.preference');
    Route::post('guest/account/home/save/preference', [PreferenceController::class, 'save'])->name('guest.account.save.preferences');

    Route::get('guest/account/FAQ', [HomeController::class,'viewFAQ'])->name('guest.faq.display');
    Route::get('guest/account/about', [HomeController::class,'viewAbout'])->name('guest.about.display');
    Route::get('guest/account/e-resources', [HomeController::class,'viewEresources'])->name('guest.eresources.display');


    Route::get('guest/account/home', [HomeController::class, 'index'])->name('guest.account.home');
    Route::get('guest/account/home/filter', [HomeController::class, 'filter'])->name('guest.account.home.filter');
    Route::post('guest/account/send/email', [SendEmailController::class,'sendEmail'])->name('guest.account.send.email');

    // Unsave and save file
    Route::post('guest/account/home/{imrad}', [MyLibraryController::class, 'save'])->name('guest.account.home.save.imrad');
    Route::delete('guest/account/unsave/{imrad}', [MyLibraryController::class, 'unsave'])->name('guest.account.home.unsave.imrad');

    Route::get('guest/account/home/{imrad}', [HomeController::class, 'viewFile'])->name('guest_account.home.view.file');
    Route::get('guest/account/home/view/mylibrary', [MyLibraryController::class, 'index'])->name('guest.account.home.view.mylibrary');
    Route::get('guest/account/home/view/myadvise', [MyLibraryController::class, 'myAdvise'])->name('guest.account.home.view.myAdvise');


    Route::get('guest/account/profile/{user_code}', [ProfileController::class, 'view'])->name('guest.account.profile');
    Route::put('guest/account/profile/{user_code}', [ProfileController::class, 'update'])->name('guest.account.update');
    Route::put('guest/account/password/profile/{user_code}', [ProfileController::class, 'updatePassword'])->name('guest.account.password.update');

    Route::get('guest/account/announcement/{announcement}', [AnnouncementController::class, 'viewAnnouncement'])->name('guest.account.view.announcement');
    Route::post('guest/account/passwordcheck/{user_code}', [ProfileController::class, 'currPass']);
    Route::post('guest/home/ratings/store', [RatingController::class, 'store'])->name('guest.account.rating.store');
});
