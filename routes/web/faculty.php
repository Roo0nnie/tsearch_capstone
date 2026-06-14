<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\AnnouncementsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImradMetricController;
use App\Http\Controllers\MyLibraryController;
use App\Http\Controllers\PreferenceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RatingController;

Route::middleware(['auth:faculty', 'role:faculty'])->group(function () {
    Route::get('faculty/preference', [PreferenceController::class, 'view'])->name('faculty.preference');
    Route::post('faculty/save/preference', [PreferenceController::class, 'save'])->name('faculty.save.preferences');
    Route::get('/faculty/home', [HomeController::class, 'index'])->name('faculty.home');
    Route::post('/faculty/home/{imrad}', [MyLibraryController::class, 'save'])->name('faculty.home.save.imrad');
    Route::get('/faculty/home/{imrad}', [HomeController::class, 'viewFile'])->name('faculty.home.view.file');
    Route::get('/faculty/home/view/mylibrary', [MyLibraryController::class, 'index'])->name('faculty.home.view.mylibrary');

    Route::get('faculty/profile/{user_code}', [ProfileController::class, 'view'])->name('faculty.profile');
    Route::put('faculty/profile/{user_code}', [ProfileController::class, 'update'])->name('faculty.update');
    Route::put('faculty/password/profile/{user_code}', [ProfileController::class, 'updatePassword'])->name('faculty.password.update');

    Route::post('faculty/passwordcheck/{user_code}', [ProfileController::class, 'currPass']);

    Route::get('faculty/announcement/{announcement}', [AnnouncementController::class, 'viewAnnouncement'])->name('faculty.view.announcement');
    Route::post('faculty/imrad/{imradID}/download', [ImradMetricController::class, 'updateDownloads'])->name('faculty.updateDownloads');

    Route::post('faculty/ratings/store', [RatingController::class, 'store'])->name('faculty.rating.store');
    Route::get('/faculty/announcements', [AnnouncementsController::class, 'index'])->name('faculty.announcements');
});
