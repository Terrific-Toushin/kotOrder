<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\AdminDashboardController;
use \App\Http\Controllers\ConfigController;
use \App\Http\Controllers\UserController;
use \App\Http\Controllers\ReportController;
use Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});

//Route::get('/', [FrontendControllers::class, 'index'])->name('home');

Route::get('/clear/route', [ConfigController::class, 'clearRoute']);
Route::get('/clear/cache', [ConfigController::class, 'clearCache']);

Route::group(['middleware' => 'auth'],function (){
    Route::get('/', [AdminDashboardController::class, 'index'])->name('home');
    Route::get('/admin-dashboard', [AdminDashboardController::class, 'index'])->name('adminDashboard');
    Route::get('/all-course-download-csv/{type}', [AdminDashboardController::class, 'allCourseDownload'])->name('allCourseDownload.csv');

//    System User List page route
    Route::get('/user-list', [UserController::class, 'index'])->name('userList')->middleware('checkprivilege:UL');
    Route::get('/user-new-add/{id}', [UserController::class, 'newUser'])->name('addUser')->middleware('checkprivilege:UE');
    Route::post('/user-info', [UserController::class, 'userCreat'])->name('storeUser')->middleware('checkprivilege:UE');
    Route::post('/user-password-change', [UserController::class, 'changeUserPassword'])->name('changePasswordUser')->middleware('checkprivilege:UE');
    Route::delete('/user-delete/{id}', [UserController::class, 'destroy'])->name('deleteUser')->middleware('checkprivilege:UD');

//    Report route
    Route::get('/report-research-application', [ReportController::class, 'researchData'])->name('researchList')->middleware('checkprivilege:RA');
    Route::get('/report-research-details/{id}', [ReportController::class, 'researchDetails'])->name('researchDetails')->middleware('checkprivilege:RA');
    Route::get('/download-pdf/{filePath}', [ReportController::class, 'downloadPDF'])->name('downloadFile')->middleware('checkprivilege:RA');
    Route::get('/download-csv/{id}', [ReportController::class, 'downloadCSV'])->name('downloadCSV')->middleware('checkprivilege:RA');
    Route::get('/report-audit-log', [ReportController::class, 'getLogData'])->name('getAuditLogData')->middleware('checkprivilege:RA');
    Route::get('/report-payment-log', [ReportController::class, 'getPaymentDetails'])->name('getPaymentDetails')->middleware('checkprivilege:RA');
});

