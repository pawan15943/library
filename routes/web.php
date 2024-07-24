<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Redirect to login form on root URL
Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');

Auth::routes();

// Home route for regular users
Route::get('/home', [DashboardController::class, 'index'])->name('home')->middleware('auth');

// Admin routes
Route::middleware(['auth', 'is_admin'])->group(function () {
    Route::get('student/transportationList', [StudentController::class, 'transportationList'])->name('student.transportationList');
    Route::get('accounts/add-payment', [AccountController::class, 'addPayment'])->name('admin.accounts_payment');
    Route::post('accounts/add-payment', [AccountController::class, 'savePayment'])->name('admin.account.save_payment');
   
    Route::resource('student', StudentController::class);
    Route::get('accounts', [AccountController::class, 'index'])->name('admin.accounts');
    Route::patch('accounts-verification', [AccountController::class, 'verifyStatus'])->name('admin.accounts_verification');
    Route::get('accounts/approve', [AccountController::class, 'approveAccountList'])->name('admin.approve');
    Route::get('accounts/rejected', [AccountController::class, 'rejectAccountList'])->name('admin.rejected');
    Route::get('plan/list', [PlanController::class, 'index'])->name('plan.index');
    Route::get('plan-name', [PlanController::class, 'craetePlanName'])->name('plan.create');
    Route::get('plan-name/{plan}/edit', [PlanController::class, 'planNameedit'])->name('plan.edit');
    Route::put('plan-name/{plan}', [PlanController::class, 'update'])->name('plan.update');
    Route::post('plan-name', [PlanController::class, 'store'])->name('plan.store');
    Route::get('planType/list', [PlanController::class, 'planTypeList'])->name('planType.index');
    Route::get('planType', [PlanController::class, 'craeteplanType'])->name('planType.create');
    Route::get('planType/{planType}/edit', [PlanController::class, 'planTypedit'])->name('planType.edit');
    Route::put('planType/{planType}', [PlanController::class, 'planTypeupdate'])->name('planType.update');
    Route::post('planType', [PlanController::class, 'planTypestore'])->name('planType.store');

    Route::get('planPrice/list', [PlanController::class, 'planPriceList'])->name('planPrice.index');
    Route::get('planPrice', [PlanController::class, 'craeteplanPrice'])->name('planPrice.create');
    Route::get('planPrice/{planPrice}/edit', [PlanController::class, 'planPricedit'])->name('planPrice.edit');
    Route::put('planPrice/{planPrice}', [PlanController::class, 'planPriceupdate'])->name('planPrice.update');
    Route::post('planPrice/store', [PlanController::class, 'planPricestore'])->name('planPrice.store');
    Route::get('getPlanType', [PlanController::class, 'getPlanType'])->name('gettypePlanwise');
    Route::get('getPrice', [PlanController::class, 'getPrice'])->name('getPricePlanwise');
    Route::get('seats/list', [UserController::class, 'index'])->name('seats');
    Route::get('seats/create', [UserController::class, 'seatCreate'])->name('seats.create');
    Route::post('seats/create', [UserController::class, 'seatStore'])->name('seats.store');
    Route::post('customers/store', [UserController::class, 'customerStore'])->name('customers.store');
    Route::get('customers/list', [UserController::class, 'custmorList'])->name('customers.list');
    Route::get('seat/history/list', [UserController::class, 'seatHistory'])->name('history.seat.list');
    Route::get('user/show', [UserController::class, 'geUser'])->name('geUser');
    Route::post('user/update', [UserController::class, 'userUpdate'])->name('user.update');
    
   
});


