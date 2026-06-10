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

Route::group(['middleware' => ['auth:admin', \App\Http\Middleware\AdminVerified::class, 'role:admin']], function () {



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

