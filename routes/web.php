<?php

use App\Http\Controllers\AdminAuth\ForgotPasswordController;
use App\Http\Controllers\AdminAuth\ResetPasswordController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminAuth\AdminLoginController;
use App\Http\Controllers\AdminAuth\RegisterController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;

use App\Http\Controllers\UserAuth\UserLoginController;
use App\Http\Controllers\UserAuth\UserForgotPasswordController;
use App\Http\Controllers\UserAuth\UserRegisterController;
use App\Http\Controllers\UserAuth\UserResetController;

use App\Http\Controllers\IMRADController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\MyLibraryController;
use App\Http\Controllers\SendEmailController;


use App\Http\Controllers\GuestAccountController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InvalidUserController;
use App\Http\Controllers\InvalidAdminController;

use App\Http\Controllers\LogHistoryController;
use App\Http\Controllers\ImradMetricController;
use App\Http\Controllers\PreferenceController;
use App\Http\Controllers\ImradExportController;
// Auth::routes();

use App\Http\Controllers\RatingController;
use App\Http\Controllers\UserExportController;
use App\Http\Controllers\LogHistoryExportController;
use App\Http\Controllers\GuestAccountExportController;
use App\Http\Controllers\TrashBinController;

use App\Http\Middleware\CheckIfUserLoggedIn;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\AnnouncementsController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Str;

Route::group(['middleware' => ['auth:superadmin', \App\Http\Middleware\SuperAdminVerified::class]], function () {
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



// ======================= Student Route Method ================================
Route::middleware(['auth:user'])->group(function () {
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

// ======================= Guest Account Route Method ================================
Route::get('guest/account/login', [GuestAccountController::class, 'showLoginForm'])->name('guest.account.login');
Route::post('guest/account/login', [GuestAccountController::class, 'login'])->name('guest.account.login.submit');
Route::get('guest/account/register', [GuestAccountController::class, 'showRegistrationForm'])->name('guest.account.register');
Route::post('guest/account/register', [GuestAccountController::class, 'register'])->name('guest.account.register.submit');
Route::post('guest/account/logout', [GuestAccountController::class, 'logout'])->name('guest.account.logout');

// ======================= Page for unauthenticated users Route ================================
Route::get('/guest/auth/google', [GuestAccountController::class, 'googleLogin'])->name('guest.auth.google');
Route::get('guest/auth/google/call-back', [GuestAccountController::class, 'callbackGoogle'])->name('guest.auth.call-back');

Route::post('guest/send/email', [SendEmailController::class,'sendEmail'])->name('guest.send.email');


Route::middleware(['auth:guest_account'], ['web'])->group(function () {
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


// ======================= Admin Route Method ================================
Route::get('admin/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('admin/login', [AdminLoginController::class, 'login'])->name('admin.login.submit');
Route::post('admin/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');
Route::get('admin/register', [RegisterController::class, 'showRegistrationForm'])->name('admin.register');
Route::post('/admin/admin', [AdminAuthController::class, 'store'])->name('admin.admin.store');

Route::get('admin/password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('admin.password.request');
Route::post('admin/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('admin.password.email');
Route::get('admin/password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('admin.password.reset');
Route::post('admin/password/reset', [ResetPasswordController::class, 'reset'])->name('admin.password.update');

Route::group(['middleware' => ['auth:admin', \App\Http\Middleware\AdminVerified::class]], function () {



    Route::get('admin/dashboard', [AdminAuthController::class, 'index'])->name('admin.dashboard');
    Route::post('admin/passwordcheck/{user_code}', [ProfileController::class, 'currPass']);

    // ======================= Dashboard ADMIN Objectives: Report Generation ================================
    Route::get('admin/report', [AdminAuthController::class, 'report'])->name('admin.report');
    Route::get('admin/file-upload', [AdminAuthController::class, 'file_upload'])->name('report.generation.file.upload');
    Route::get('/report/file-sdg', [AdminAuthController::class, 'file_sdg'])->name('report.generation.file.sdg');
    Route::get('/report/file-rating', [AdminAuthController::class, 'file_rating'])->name('report.generation.file.rating');

    // ======================= Dashboard ADMIN CRUD method ================================
    // Admin manage setting
    Route::get('admin/setting', [SettingController::class, 'setting'])->name('admin.setting');
    Route::put('admin/setting/set-date', [SettingController::class, 'setArchive'])->name('admin.set.date.archive');
    Route::put('admin/setting/set-delete', [SettingController::class, 'setDelete'])->name('admin.set.date.delete');

    // Admin manage passwords
    Route::get('admin/profile/{admin}', [ProfileController::class, 'adminProfile'])->name('admin.profile');
    Route::put('admin/profile/update/{admin}', [ProfileController::class, 'adminProfileupdate'])->name('admin.profile.update');

    Route::put('admin/profile/updatePass/{admin}', [ProfileController::class, 'adminupdatePassword'])->name('admin.profile.password.update');
    Route::put('admin/profile/picture/{admin}', [ProfileController::class, 'profilePicture'])->name('admin.profile.picture');



// ======================= Dashboard USER CRUD method ================================
    Route::get('admin/user', [UserController::class, 'view'])->name('admin.user');
    Route::post('/admin/user', [UserController::class, 'store'])->name('admin.user.store');
    Route::post('/admin/user/import', [UserController::class, 'excelstore'])->name('admin.user.import.store');
    Route::get('admin/user/create', [UserController::class, 'create'])->name('admin.user.create');
    Route::get('admin/user/edit/{user}', [UserController::class, 'edit'])->name('admin.user.edit');
    Route::put('admin/user/update/{user}', [UserController::class, 'update'])->name('admin.user.update');
    Route::delete('admin/user/delete/{user}', [UserController::class, 'destroy'])->name('admin.user.delete');
    Route::post('/admin/user/search', [UserController::class, 'searchUser'])->name('admin.user.search');
    Route::post('/admin/invaliduser/search', [UserController::class, 'searchUserInvalid'])->name('admin.invaliduser.search');

    Route::get('admin/view-pdf', [UserExportController::class, 'viewPdf'])->name('view.pdf');
    Route::get('admin/download-pdf', [UserExportController::class, 'downloadPdf'])->name('download.pdf');
    Route::get('admin/export-excel', [UserExportController::class, 'exportExcel'])->name('export.excel');

    Route::get('admin/active/view-pdf', [UserExportController::class, 'ActiveViewPdf'])->name('active.view.pdf');
    Route::get('admin/active/download-pdf', [UserExportController::class, 'ActiveDownloadPdf'])->name('active.download.pdf');
    Route::get('admin/active/export-excel', [UserExportController::class, 'exportExcelOnline'])->name('active.export.excel');

    Route::get('admin/inactive/view-pdf', [UserExportController::class, 'InactiveViewPdf'])->name('inactive.view.pdf');
    Route::get('admin/inactive/download-pdf', [UserExportController::class, 'InactiveDownloadPdf'])->name('inactive.download.pdf');
    Route::get('admin/inactive/export-excel', [UserExportController::class, 'exportExcelOffline'])->name('inactive.export.excel');

    Route::get('admin/invalid/view-pdf', [UserExportController::class, 'InvalidViewPdf'])->name('invalid.view.pdf');
    Route::get('admin/invalid/download-pdf', [UserExportController::class, 'InvalidDownloadPdf'])->name('invalid.download.pdf');
    Route::get('admin/invalid/export-excel', [UserExportController::class, 'invalidUserExportExcel'])->name('invalid.export.excel');

    Route::get('admin/userinvalid/edit/{invaliduser}', [InvalidUserController::class, 'edit'])->name('admin.invaliduser.edit');
    Route::put('admin/userinvalid/update/{invaliduser}', [InvalidUserController::class, 'update'])->name('admin.invaliduser.update');
    Route::delete('admin/userinvalid/delete/{invaliduser}', [InvalidUserController::class, 'destroy'])->name('admin.invaliduser.delete');

    // ======================= Dashboard FACULTY CRUD method ================================
    // Route::get('admin/faculty', [FacultyController::class, 'view'])->name('admin.faculty');
    // Route::post('/admin/faculty', [FacultyController::class, 'store'])->name('admin.faculty.store');
    Route::get('admin/faculty/create', [FacultyController::class, 'create'])->name('admin.faculty.create');
    Route::get('admin/faculty/edit/{faculty}', [FacultyController::class, 'edit'])->name('admin.faculty.edit');
    Route::put('admin/faculty/update/{faculty}', [FacultyController::class, 'update'])->name('admin.faculty.update');
    Route::delete('admin/faculty/delete/{faculty}', [FacultyController::class, 'destroy'])->name('admin.faculty.delete');

    Route::post('/admin/faculty/search', [FacultyController::class, 'searchFaculty'])->name('admin.faculty.search');
    Route::post('/admin/invalidfaculty/search', [FacultyController::class, 'searchFacultyInvalid'])->name('admin.invalidfaculty.search');

    Route::post('/admin/faculty/import', [FacultyController::class, 'excelstore'])->name('admin.faculty.import.store');

    Route::get('admin/faculty/view-pdf', [FacultyExportController::class, 'viewPdf'])->name('faculty.view.pdf');
    Route::get('admin/faculty/download-pdf', [FacultyExportController::class, 'downloadPdf'])->name('faculty.download.pdf');
    Route::get('admin/faculty/export-excel', [FacultyExportController::class, 'exportExcel'])->name('faculty.export.excel');

    Route::get('admin/faculty/active/view-pdf', [FacultyExportController::class, 'ActiveViewPdf'])->name('faculty.active.view.pdf');
    Route::get('admin/faculty/active/download-pdf', [FacultyExportController::class, 'ActiveDownloadPdf'])->name('faculty.active.download.pdf');
    Route::get('admin/faculty/active/export-excel', [FacultyExportController::class, 'exportExcelOnline'])->name('faculty.active.export.excel');

    Route::get('admin/faculty/inactive/view-pdf', [FacultyExportController::class, 'InactiveViewPdf'])->name('faculty.inactive.view.pdf');
    Route::get('admin/faculty/inactive/download-pdf', [FacultyExportController::class, 'InactiveDownloadPdf'])->name('faculty.inactive.download.pdf');
    Route::get('admin/faculty/inactive/export-excel', [FacultyExportController::class, 'exportExcelOffline'])->name('faculty.inactive.export.excel');

    Route::get('admin/faculty/invalid/view-pdf', [FacultyExportController::class, 'InvalidViewPdf'])->name('faculty.invalid.view.pdf');
    Route::get('admin/faculty/invalid/download-pdf', [FacultyExportController::class, 'InvalidDownloadPdf'])->name('faculty.invalid.download.pdf');
    Route::get('admin/faculty/invalid/export-excel', [FacultyExportController::class, 'invalidexportExcel'])->name('faculty.invalid.export.excel');

    Route::get('admin/invalidfaculty/edit/{invalidfaculty}', [InvalidFacultyController::class, 'edit'])->name('admin.invalidfaculty.edit');
    Route::put('admin/invalidfaculty/update/{invalidfaculty}', [InvalidFacultyController::class, 'update'])->name('admin.invalidfaculty.update');
    Route::delete('admin/invalidfaculty/delete/{invalidfaculty}', [InvalidFacultyController::class, 'destroy'])->name('admin.invalidfaculty.delete');

    // ======================= Download File in the Admin method ================================
    Route::get('admin/download/pdf/log', [ImradExportController::class, 'downloadlogFile'])->name('download.pdf.logs.admin');
    Route::get('admin/download/pdf/deleted-file', [ImradExportController::class, 'downloadDeletedFileFile'])->name('download.pdf.deletedfile.admin');
    Route::get('admin/download/pdf/deleted-user', [ImradExportController::class, 'downloadDeletedUserFile'])->name('download.pdf.deleteduser.admin');
    Route::get('admin/download/pdf/user', [ImradExportController::class, 'downloadUserFile'])->name('download.pdf.user.admin');

    Route::get('admin/download/pdf/file', [ImradExportController::class, 'downloadListFile'])->name('download.pdf.file.admin');
    Route::get('admin/download/excel/file', [ImradExportController::class, 'downloadListExcel'])->name('download.excel.file.admin');

    Route::get('admin/download/pdf/draft', [ImradExportController::class, 'downloadDraftFile'])->name('download.pdf.file.draft');
    Route::get('admin/download/excel/draft', [ImradExportController::class, 'downloadDraftExcel'])->name('download.excel.file.draft');
    // For SDG
    Route::get('admin/download/file/sdg', [ImradExportController::class, 'downloadSDGFile'])->name('download.pdf.file.sdg');
    Route::get('admin/download/excel/sdg', [ImradExportController::class, 'downloadSDGExcel'])->name('download.excel.file.sdg');

    // For Rating
    Route::get('admin/download/file/rate', [ImradExportController::class, 'downloadRateFile'])->name('download.pdf.file.rate');
    Route::get('admin/download/excel/rate', [ImradExportController::class, 'downloadRateExcel'])->name('download.excel.file.rate');

    // ======================= Dashboard GUEST ACCOUNT CRUD method ================================
    Route::get('admin/guestAccount', [GuestAccountController::class, 'view'])->name('admin.guestAccount');
    Route::get('admin/faculty', [GuestAccountController::class, 'facultyView'])->name('admin.faculty');
    Route::put('admin/changeStatus_faculty', [GuestAccountController::class, 'changeToFaculty'])->name('admin.change.to.faculty');
    Route::put('admin/changeStatus_status', [GuestAccountController::class, 'changeToStudent'])->name('admin.change.to.student');

    Route::post('/admin/guestAccount', [GuestAccountController::class, 'storefromadmin'])->name('admin.guestAccount.store');
    Route::get('admin/guestAccount/create', [GuestAccountController::class, 'createfromadmin'])->name('admin.guestAccount.create');
    Route::get('admin/guestAccount/edit/{guestAccount}', [GuestAccountController::class, 'edit'])->name('admin.guestAccount.edit');
    Route::put('admin/guestAccount/update/{guestAccount}', [GuestAccountController::class, 'update'])->name('admin.guestAccount.update');
    Route::delete('admin/guestAccount/delete', [GuestAccountController::class, 'destroy'])->name('admin.guestAccount.delete');

    Route::post('/admin/guestAccount/search', [GuestAccountController::class, 'searchguestAccount'])->name('admin.guestAccount.search');

    Route::get('admin/guestAccount/view-pdf', [GuestAccountExportController::class, 'viewPdf'])->name('guestAccount.view.pdf');
    Route::get('admin/guestAccount/download-pdf', [GuestAccountExportController::class, 'downloadPdf'])->name('guestAccount.download.pdf');
    Route::get('admin/guestAccount/export-excel', [GuestAccountExportController::class, 'exportExcel'])->name('guestAccount.export.excel');

    Route::get('admin/guestAccount/active/view-pdf', [GuestAccountExportController::class, 'ActiveViewPdf'])->name('guestAccount.active.view.pdf');
    Route::get('admin/guestAccount/active/download-pdf', [GuestAccountExportController::class, 'ActiveDownloadPdf'])->name('guestAccount.active.download.pdf');
    Route::get('admin/guestAccount/active/export-excel', [GuestAccountExportController::class, 'exportExcelOnline'])->name('guestAccount.active.export.excel');

    Route::get('admin/guestAccount/inactive/view-pdf', [GuestAccountExportController::class, 'InactiveViewPdf'])->name('guestAccount.inactive.view.pdf');
    Route::get('admin/guestAccount/inactive/download-pdf', [GuestAccountExportController::class, 'InactiveDownloadPdf'])->name('guestAccount.inactive.download.pdf');
    Route::get('admin/guestAccount/inactive/export-excel', [GuestAccountExportController::class, 'exportExcelOffline'])->name('guestAccount.inactive.export.excel');

    Route::get('admin/guestAccount/blocked/view-pdf', [GuestAccountExportController::class, 'BlockedViewPdf'])->name('guestAccount.blocked.view.pdf');
    Route::get('admin/guestAccount/blocked/download-pdf', [GuestAccountExportController::class, 'BlockedDownloadPdf'])->name('guestAccount.blocked.download.pdf');
    Route::get('admin/guestAccount/blocked/export-excel', [GuestAccountExportController::class, 'exportExcelBlocked'])->name('guestAccount.blocked.export.excel');

    Route::get('admin/guestAccount/view/{guestAccount}', [GuestAccountController::class, 'userview'])->name('admin.guestAccount.view');
    Route::post('admin/guestAccount/add-thesis', [GuestAccountController::class, 'storeSelectedThesis'])->name('admin.guestAccount.add.thesis');
    Route::delete('admin/my-thesis/{id}', [GuestAccountController::class, 'mythesisdestroy'])->name('my-thesis.destroy');


    Route::get('admin/log/view-pdf', [LogHistoryExportController::class, 'viewPdf'])->name('log.view.pdf');
    Route::get('admin/log/download-pdf', [LogHistoryExportController::class, 'downloadPdf'])->name('log.download.pdf');
    Route::get('admin/log/export-excel', [LogHistoryExportController::class, 'exportExcel'])->name('log.export.excel');

    // ======================= Dashboard IMRAD CRUD method ================================
    Route::get('admin/file/published', [IMRADController::class, 'file_published'])->name('admin.file.published');
    Route::get('admin/file/archived', [IMRADController::class, 'file_archived'])->name('admin.file.archived');
    Route::get('admin/file/draft', [IMRADController::class, 'file_draft'])->name('admin.file.draft');

    Route::post('admin/imrad', [IMRADController::class, 'store'])->name('admin.imrad.store');
    Route::get('admin/imrad/create', [IMRADController::class, 'create'])->name('admin.imrad.create');
    Route::get('admin/imrad/edit/{imrad}', [IMRADController::class, 'edit'])->name('admin.imrad.edit');
    Route::put('admin/imrad/update/{imrad}', [IMRADController::class, 'update'])->name('admin.imrad.update');
    Route::delete('admin/imrad/delete/{imrad}', [IMRADController::class, 'destroy'])->name('admin.imrad.delete');
    Route::delete('admin/bulk-delete-draft', [IMRADController::class, 'bulkDeleteDraft'])->name('admin.bulk-delete.draft');
    Route::delete('admin/bulk-delete', [IMRADController::class, 'bulkDelete'])->name('admin.bulk-delete');
    Route::put('admin/bulk-archive', [IMRADController::class, 'bulkArchive'])->name('admin.select.archive');
    Route::put('admin/bulk-published', [IMRADController::class, 'bulkPublished'])->name('admin.select.published');


    // Route::delete('admin/archive/delete/{archive}', [IMRADController::class, 'destroyArhive'])->name('admin.archive.delete');
    // Route::delete('admin/temp/delete/{temp}', [IMRADController::class, 'destroyTemp'])->name('admin.temp.delete');

    Route::get('admin/imrad/view/{imrad}', [IMRADController::class, 'imradview'])->name('admin.imrad.view');
    Route::get('admin/imrad/view/temp/{tempfile}', [IMRADController::class, 'imradviewtemp'])->name('admin.imrad.view.temp');

    Route::get('admin/tempimrad/edit/{tempfile}', [IMRADController::class, 'editTemp'])->name('admin.temp.edit');

    Route::post('/admin/imrad/search', [IMRADController::class, 'searchImrad'])->name('admin.imrad.search');
    Route::post('/admin/temp/search', [IMRADController::class, 'searchTemp'])->name('admin.temp.search');
    Route::post('/admin/archive/search', [IMRADController::class, 'searchArchive'])->name('admin.archive.search');

    Route::get('/admin/archive/{imrad}', [IMRADController::class, 'archive'])->name('admin.imrad.archive');

    Route::post('/admin/imrad/create', [IMRADController::class, 'pdfscan'])->name('admin.imrad.create');
    Route::get('/admin/imrad/manual/add', [IMRADController::class, 'manual_add'])->name('admin.imrad.manual.add');
    Route::post('/admin/imrad/manual/create', [IMRADController::class, 'manual_create'])->name('admin.imrad.manual.create');

    // ======================= Dashboard Annoucement CRUD method ================================
    Route::get('admin/announcement', [AnnouncementController::class, 'view'])->name('admin.announcement');
    Route::post('admin/announcement', [AnnouncementController::class, 'store'])->name('admin.announcement.store');

    Route::post('admin/announcement/{id}', [AnnouncementController::class, 'updateStatus']);

    Route::get('admin/announcement/create', [AnnouncementController::class, 'create'])->name('admin.announcement.create');
    Route::get('admin/announcement/edit/{announcement}', [AnnouncementController::class, 'edit'])->name('admin.announcement.edit');
    Route::put('admin/announcement/update/{announcement}', [AnnouncementController::class, 'update'])->name('admin.announcement.update');
    Route::delete('admin/announcement/delete/{announcement}', [AnnouncementController::class, 'destroy'])->name('admin.announcement.delete');
    Route::post('admin/announcement/stop/{announcement}', [AnnouncementController::class, 'stop'])->name('announcement.stop');
    Route::post('admin/announcement/continue/{announcement}', [AnnouncementController::class, 'continue'])->name('announcement.continue');

    // ======================= Dashboard Log History CRUD method ================================
    Route::get('admin/log', [LogHistoryController::class, 'view'])->name('admin.log');

    // ======================= Dashboard Dashboard/Reports method ================================
    Route::get('admin/filecount', [ReportController::class, 'reportfilecount'])->name('admin.filecount');;
    Route::get('admin/reports/filecount', [ReportController::class, 'viewfileupload']);

    Route::get('admin/getData', [ReportController::class, 'reportsBarSDG'])->name('admin.getData');
    Route::get('admin/reports', [ReportController::class, 'viewReports']);

    Route::get('admin/getDatalinegraph', [ReportController::class, 'reportsLineSDG'])->name('admin.getDatalinegraph');
    Route::get('admin/linegraph', [ReportController::class, 'viewLineSDG']);

    Route::get('admin/getDataUserStatistics', [ReportController::class, 'getDataUserStatistics'])->name('admin.getDataUserStatistics');
    Route::get('admin/UserStatistics', [ReportController::class, 'viewDataUserStatistics']);

    Route::get('admin/getUserDemographics', [ReportController::class, 'getUserDemographics'])->name('admin.getUserDemographics');
    Route::get('admin/UserDemographics', [ReportController::class, 'viewUserDemographics']);



    // Route::get('admin/trash-bin', [TrashBinController::class, 'view'])->name('admin.trash-bin');
    Route::get('admin/trash-file', [TrashBinController::class, 'trashViewFile'])->name('admin.trash-file');
    Route::get('admin/trash-user', [TrashBinController::class, 'trashViewUser'])->name('admin.trash-user');
    Route::put('admin/trash-bin', [TrashBinController::class, 'recover'])->name('admin.user.recover');
    Route::delete('admin/trash-destroy', [TrashBinController::class, 'destroy'])->name('admin.user.destroy');

    Route::delete('admin/trash-destroy/auto/{user}', [TrashBinController::class, 'destroyAutomatic'])->name('admin.user.destroy');
    Route::put('/admin/recover/', [TrashBinController::class, 'recoverImrad'])->name('admin.archive.recover');
    Route::delete('admin/trash-destroy/imrad/{archive}', [TrashBinController::class, 'delete'])->name('admin.trash-bin.delete');
    Route::delete('/admin/trash-destroy/imrad/select/delete', [TrashBinController::class, 'trashDelete'])->name('admin.trash-bin.select.delete');

});

