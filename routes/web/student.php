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
// ======================= Student Route Method ================================
Route::middleware(['auth:user', 'role:student'])->group(function () {
    Route::get('home/preference', [PreferenceController::class, 'view'])->name('user.preference');
    Route::post('home/save/preference', [PreferenceController::class, 'save'])->name('user.save.preferences');
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::post('/home/{imrad}', [MyLibraryController::class, 'save'])->name('home.save.imrad');
    Route::get('/home/{imrad}', [HomeController::class, 'viewFile'])->name('home.view.file');
    Route::get('/home/view/mylibrary', [MyLibraryController::class, 'index'])->name('home.view.mylibrary');

    Route::get('home/profile/{user_code}', [ProfileController::class, 'view'])->name('home.profile');
    Route::put('home/profile/{user_code}', [ProfileController::class, 'update'])->name('home.update');
    Route::put('home/password/profile/{user_code}', [ProfileController::class, 'updatePassword'])->name('home.password.update');

    Route::post('home/passwordcheck/{user_code}', [ProfileController::class, 'currPass']);

    Route::get('home/announcement/{announcement}', [AnnouncementController::class, 'viewAnnouncement'])->name('home.view.announcement');
    Route::post('home/imrad/{imradID}/download', [ImradMetricController::class, 'updateDownloads'])->name('updateDownloads');

    Route::post('home/ratings/store', [RatingController::class, 'store'])->name('rating.store');
    Route::get('/announcements', [AnnouncementsController::class, 'index'])->name('announcements');
});
