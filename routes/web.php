<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\AdminDashboardController;
use \App\Http\Controllers\ConfigController;
use \App\Http\Controllers\UserController;
use \App\Http\Controllers\ReportController;
use \App\Http\Controllers\OperatorController;
use \App\Http\Controllers\KitchenController;
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
    Route::get('/', [AdminDashboardController::class, 'redirects'])->name('home');
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

    Route::get('/admin-kotView/{billNo}', [ReportController::class, 'adminKotView'])->name ('kotViewAdmin');
    Route::get('/admin-cashPrint', [ReportController::class, 'cashPrint'])->name ('adminCashPrint');
    Route::post('/admin-cashPrint-filter', [ReportController::class, 'filterCashPrint'])->name ('filterCashPrint');
    Route::get('/admin-totalKOT', [ReportController::class, 'adminTotalKOT'])->name ('adminTotalKOT');
    Route::post('/admin-totalKOT-filter', [ReportController::class, 'filterTotalKot'])->name ('filterTotalKot');
    Route::get('/all-pendingKOT', [ReportController::class, 'allPendingKOT'])->name ('pendingKOTAll');
    Route::post('/all-pendingKOT-filter', [ReportController::class, 'filterAllPendingKOT'])->name ('filterPendingKOTAll');
    Route::get('/all-kitchenCompleteKOTHistory', [ReportController::class, 'KitchenCompleteKOTHistoryAll'])->name ('KitchenCompleteKOTHistoryAll');
    Route::post('/all-kitchenCompleteKOTHistory-filter', [ReportController::class, 'filterKitchenCompleteKOTHistory'])->name ('filterKitchenCompleteKOTHistory');
});

// Start Group Operator Middleware
Route::middleware(['auth','checkprivilege:OPT'])->group(function(){
    Route::get('/operator-outlet', [OperatorController::class, 'OperatorOutlets'])->name ('outlets');
    Route::get('/operator-select-outlet/{uotlet}/{uotletName}', [OperatorController::class, 'OperatorSetOutlets'])->name ('selectOutlets');
    Route::get('/operator-dashboard', [OperatorController::class, 'OperatorDashboard'])->name ('operatorDashboard');
    Route::get('/operator-profile', [OperatorController::class, 'OperatorProfile'])->name ('profile');
    Route::post('/operator-profileUpdateSave', [OperatorController::class, 'ProfileUpdateSave'])->name ('profileUpdateSave');
    Route::post('/operator-changePasswordSave', [OperatorController::class, 'ChangePasswordSave'])->name ('changePasswordSave');
    Route::get('/operator-newOrder', [OperatorController::class, 'NewOrder'])->name ('newOrder');
    Route::post('/operator-newOrderItem', [OperatorController::class, 'NewOrderItem'])->name ('newOrderItem');
    Route::get('/operator-tableExist', [OperatorController::class, 'TableExist'])->name ('tableExist');
    Route::get('/operator-roomExist', [OperatorController::class, 'RoomExist'])->name ('roomExist');
    Route::post('/operator-newOrder-ItemSave', [OperatorController::class, 'NewOrderItemSave'])->name ('newOrderItemSave');
    Route::post('/operator-editOrder-AddItemSave', [OperatorController::class, 'EditOrderAddItemSave'])->name ('editOrderAddItemSave');
    Route::get('/operator-editOrderItem', [OperatorController::class, 'EditOrderItem'])->name ('editOrderItem');
    Route::get('/operator-orderCancle', [OperatorController::class, 'OrderCancle'])->name ('orderCancle');
    Route::get('/operator-itemCancle', [OperatorController::class, 'ItemCancle'])->name ('itemCancle');
    Route::get('/operator-kotView', [OperatorController::class, 'OperatorKotView'])->name ('kotView');
    Route::get('/operator-orderHistry', [OperatorController::class, 'OperatorOrderHistry'])->name ('orderHistry');
    Route::get('/operator-sendToKOT', [OperatorController::class, 'OperatorSendToKOT'])->name ('sendToKOT');
    Route::get('/operator-pendingKOT', [OperatorController::class, 'OperatorPendingKOT'])->name ('pendingKOT');
    Route::get('/operator-kitchenCompleteKOTHistory', [OperatorController::class, 'KitchenCompleteKOTHistory'])->name ('operatorCompleteKOTHistory');
    Route::get('/operator-totalKOT', [OperatorController::class, 'OperatorTotalKOT'])->name ('totalKOT');
    Route::get('/operator-cashPrint', [OperatorController::class, 'OperatorCashPrint'])->name ('cashPrint');
}); // End Group Operator Middleware

Route::middleware(['auth','checkprivilege:KOT'])->group(function(){
    Route::get('/kitchen/dashboard', [KitchenController::class, 'KitchenDashboard'])->name ('kitchenDashboard');
    Route::get('/kitchen/profile', [KitchenController::class, 'KitchenProfile'])->name ('kitchenProfile');
    Route::post('/kitchen/profileUpdateSave', [KitchenController::class, 'KitchenProfileUpdateSave'])->name ('kitchenProfileUpdateSave');
    Route::get('/kitchen/changePassword', [KitchenController::class, 'KitchenChangePassword'])->name ('kitchenChangePassword');
    Route::post('/kitchen/changePasswordSave', [KitchenController::class, 'ChangePasswordSave'])->name ('kitchenChangePasswordSave');
    Route::get('/kitchen/kotView', [KitchenController::class, 'KitchenKOTView'])->name ('kitchenKotView');
    Route::get('/kitchen/pendingKOT', [KitchenController::class, 'KitchenPendingKOT'])->name ('kitchenPendingKOT');
    Route::get('/kitchen/kitchenCompleteKOTHistory', [KitchenController::class, 'KitchenCompleteKOTHistory'])->name ('kitchenCompleteKOTHistory');
    Route::get('/kitchen/kitchenCompleteKOT:id', [KitchenController::class, 'KitchenCompleteKOT'])->name ('kitchenCompleteKOT');
});

