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

Route::group(['middleware' => ['auth:superadmin', \App\Http\Middleware\SuperAdminVerified::class, 'role:superadmin']], function () {
    Route::get('super_admin/dashboard', [SuperAdminController::class, 'dashboard'])->name('superadmin.super_dashboard');
    Route::post('superadmin/logout', [SuperAdminController::class, 'logout'])->name('superadmin.logout');

    Route::get('superadmin/trash-bin', [TrashBinController::class, 'trashview'])->name('superadmin.trash-bin');
    Route::get('superadmin/trash-bin/{admin}', [TrashBinController::class, 'recoveradmin'])->name('superadmin.admin.recover');

    Route::get('superadmin/profile/{superadmin}', [ProfileController::class, 'superadminProfile'])->name('superadmin.profile');
    Route::put('superadmin/profile/update/{superadmin}', [ProfileController::class, 'superadminProfileupdate'])->name('superadmin.profile.update');

    Route::put('superadmin/profile/updatePass/{superadmin}', [ProfileController::class, 'superadminupdatePassword'])->name('superadmin.profile.password.update');
    Route::put('superadmin/profile/picture/{superadmin}', [ProfileController::class, 'superadminprofilePicture'])->name('superadmin.profile.picture');

    // ======================= Super Admin manage User/Student Route ================================
    Route::get('super_admin/user', [UserController::class, 'view'])->name('super_admin.user');
    Route::post('super_admin/user', [UserController::class, 'store'])->name('super_admin.user.store');
    Route::post('super_admin/user/import', [UserController::class, 'excelstore'])->name('super_admin.user.import.store');
    Route::get('super_admin/user/create', [UserController::class, 'create'])->name('super_admin.user.create');
    Route::get('super_admin/user/edit/{user}', [UserController::class, 'edit'])->name('super_admin.user.edit');
    Route::put('super_admin/user/update/{user}', [UserController::class, 'update'])->name('super_admin.user.update');
    Route::delete('super_admin/user/delete/{user}', [UserController::class, 'destroy'])->name('super_admin.user.delete');
    Route::post('super_admin/user/search', [UserController::class, 'searchUser'])->name('super_admin.user.search');
    Route::post('super_admin/invaliduser/search', [UserController::class, 'searchUserInvalid'])->name('super_admin.super_admin.invaliduser.search');

    Route::get('super_admin/view-pdf', [UserExportController::class, 'viewPdf'])->name('super_admin.view.pdf');
    Route::get('super_admin/download-pdf', [UserExportController::class, 'downloadPdf'])->name('super_admin.download.pdf');
    Route::get('super_admin/export-excel', [UserExportController::class, 'exportExcel'])->name('super_admin.export.excel');

    Route::get('super_admin/active/view-pdf', [UserExportController::class, 'ActiveViewPdf'])->name('super_admin.active.view.pdf');
    Route::get('super_admin/active/download-pdf', [UserExportController::class, 'ActiveDownloadPdf'])->name('super_admin.active.download.pdf');
    Route::get('super_admin/active/export-excel', [UserExportController::class, 'exportExcelOnline'])->name('super_admin.active.export.excel');

    Route::get('super_admin/inactive/view-pdf', [UserExportController::class, 'InactiveViewPdf'])->name('super_admin.inactive.view.pdf');
    Route::get('super_admin/inactive/download-pdf', [UserExportController::class, 'InactiveDownloadPdf'])->name('super_admin.inactive.download.pdf');
    Route::get('super_admin/inactive/export-excel', [UserExportController::class, 'exportExcelOffline'])->name('super_admin.inactive.export.excel');

    Route::get('super_admin/invalid/view-pdf', [UserExportController::class, 'InvalidViewPdf'])->name('super_admin.invalid.view.pdf');
    Route::get('super_admin/invalid/download-pdf', [UserExportController::class, 'InvalidDownloadPdf'])->name('super_admin.invalid.download.pdf');
    Route::get('super_admin/invalid/export-excel', [UserExportController::class, 'invalidUserExportExcel'])->name('super_admin.invalid.export.excel');

    Route::get('super_admin/userinvalid/edit/{invaliduser}', [InvalidUserController::class, 'edit'])->name('super_admin.invaliduser.edit');
    Route::put('super_admin/userinvalid/update/{invaliduser}', [InvalidUserController::class, 'update'])->name('super_admin.invaliduser.update');
    Route::delete('super_admin/userinvalid/delete/{invaliduser}', [InvalidUserController::class, 'destroy'])->name('super_admin.invaliduser.delete');

// ======================= Super Admin manage Admin Route ================================
    Route::get('super_admin/admin', [AdminAuthController::class, 'view'])->name('super_admin.admin');
    Route::get('superadmin/admin/view/{admin}', [AdminAuthController::class, 'userview'])->name('superadmin.admin.view');

    Route::post('super_admin/admin/import', [AdminAuthController::class, 'excelstore'])->name('super_admin.admin.import.store');
    Route::get('super_admin/admin/create', [AdminAuthController::class, 'create'])->name('super_admin.admin.create');
    Route::get('super_admin/admin/edit/{admin}', [AdminAuthController::class, 'edit'])->name('super_admin.admin.edit');
    Route::put('super_admin/admin/update/{admin}', [AdminAuthController::class, 'update'])->name('super_admin.admin.update');
    Route::delete('super_admin/admin/delete/{admin}', [AdminAuthController::class, 'destroy'])->name('super_admin.admin.delete');
    Route::post('super_admin/admin/search', [AdminAuthController::class, 'searchAdmin'])->name('super_admin.admin.search');

    Route::get('super_admin/admininvalid/edit/{invalidadmin}', [InvalidAdminController::class, 'edit'])->name('super_admin.invalidadmin.edit');
    Route::put('super_admin/admininvalid/update/{invalidadmin}', [InvalidAdminController::class, 'update'])->name('super_admin.invalidadmin.update');
    Route::delete('super_admin/admininvalid/delete/{invalidadmin}', [InvalidAdminController::class, 'destroy'])->name('super_admin.invalidadmin.delete');

    Route::delete('superadmin/trash-destroy/{admin}', [InvalidAdminController::class, 'destroy'])->name('superadmin.admin.destroy');

    // ======================= Super Admin Dashboard Route ================================
    Route::get('superadmin/getDataUserStatistics', [ReportController::class, 'supergetDataUserStatistics'])->name('superadmin.getDataUserStatistics');
    Route::get('superadmin/getUserDemographics', [ReportController::class, 'supergetUserDemographics'])->name('superadmin.getUserDemographics');
    Route::get('superadmin/getData', [ReportController::class, 'superreportsBarSDG'])->name('superadmin.getData');
    Route::get('superadmin/getDatalinegraph', [ReportController::class, 'superreportsLineSDG'])->name('superadmin.getDatalinegraph');

    Route::get('superadmin/filecount', [ReportController::class, 'superreportfilecount'])->name('superadmin.filecount');;

});
