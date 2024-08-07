<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CourseTypeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DataController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\StateController;
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
Route::get('/welcome-new', function () {
    return view('welcome');
});
Route::post('/check-variable', [ResetPasswordController::class, 'checkVariable'])->name('check.variable');
// Redirect to login form on root URL
Route::middleware(['license.check'])->group(function () {
Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');

Auth::routes();

// Home route for regular users
Route::get('/home', [DashboardController::class, 'index'])->name('home')->middleware('auth');

// Admin routes

    Route::middleware(['auth', 'is_admin'])->group(function () {
        Route::get('menu/create', [DataController::class, 'create'])->name('menu.create');
        Route::post('menu/store', [DataController::class, 'store'])->name('menu.store');
        Route::get('menu/edit/{id?}', [DataController::class, 'edit'])->name('menu.edit');
        Route::put('menu/update', [DataController::class, 'update'])->name('menu.update');
        Route::delete('menu/destroy', [DataController::class, 'delete'])->name('menu.destroy');

        Route::get('submenu/create', [DataController::class, 'submenu_create'])->name('submenu.create');
        Route::post('submenu/store', [DataController::class, 'submenu_store'])->name('submenu.store');
        Route::get('submenu/edit/{id?}', [DataController::class, 'submenu_edit'])->name('submenu.edit');
        Route::put('submenu/update', [DataController::class, 'submenu_update'])->name('submenu.update');
        Route::delete('submenu/destroy', [DataController::class, 'submenu_delete'])->name('submenu.destroy');

        Route::get('student/transportationList', [StudentController::class, 'transportationList'])->name('student.transportationList');
        Route::get('accounts/add-payment/{id}', [AccountController::class, 'addPayment'])->name('admin.accounts_payment');
        Route::post('accounts/make-payment', [AccountController::class, 'savePayment'])->name('admin.account.save_payment');
    
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
        Route::get('getPlanTypeSeatWise', [PlanController::class, 'getPlanTypeSeatWise'])->name('gettypeSeatwise');
        Route::get('getPrice', [PlanController::class, 'getPrice'])->name('getPricePlanwise');
        Route::get('getPricePlanwiseUpgrade', [PlanController::class, 'getPricePlanwiseUpgrade'])->name('getPricePlanwiseUpgrade');
        Route::get('seats/list', [UserController::class, 'index'])->name('seats');
        Route::get('seats/create', [UserController::class, 'seatCreate'])->name('seats.create');
        Route::post('seats/create', [UserController::class, 'seatStore'])->name('seats.store');
        Route::post('customers/store', [UserController::class, 'customerStore'])->name('customers.store');
        Route::get('customers/list', [UserController::class, 'custmorList'])->name('customers.list');
        Route::get('seat/history/list', [UserController::class, 'seatHistory'])->name('history.seat.list');
        Route::get('user/show/{id?}', [UserController::class, 'getUser'])->name('geUser');
        Route::get('user/edit/{id?}', [UserController::class, 'getUser'])->name('edit.user');
        Route::get('user/close/{id?}', [UserController::class, 'getUser'])->name('close.customer');
        // Define a single route that can handle both cases


        Route::put('user/update/{id?}', [UserController::class, 'userUpdate'])->name('cutomer.update');
        Route::post('user/update/', [UserController::class, 'userUpdate'])->name('user.update');
        
        Route::get('/state', [StateController::class, 'index'])->name('state');
        Route::post('/state/store', [StateController::class, 'store'])->name('state.store');
        Route::get('/state/edit', [StateController::class, 'edit'])->name('state.edit');
        Route::delete('state/{id}', [StateController::class, 'destroy'])->name('state.destroy');
        Route::get('/city', [CityController::class, 'index'])->name('city');
        Route::post('/city/store', [CityController::class, 'store'])->name('city.store');
        Route::get('/city/edit', [CityController::class, 'edit'])->name('city.edit');
        Route::post('city/destroy', [CityController::class, 'destroy'])->name('city.destroy');

        Route::get('/class', [GradeController::class, 'index'])->name('class');
        Route::post('/class/store', [GradeController::class, 'store'])->name('class.store');
        Route::get('/class/edit', [GradeController::class, 'edit'])->name('class.edit');
        Route::post('class/destroy', [GradeController::class, 'destroy'])->name('class.destroy');

        Route::get('/course', [CourseController::class, 'index'])->name('course');
        Route::post('/course/store', [CourseController::class, 'store'])->name('course.store');
        Route::get('/course/edit', [CourseController::class, 'edit'])->name('course.edit');
        Route::post('course/destroy', [CourseController::class, 'destroy'])->name('course.destroy');

        Route::get('/course-type', [CourseTypeController::class, 'index'])->name('courseType');
        Route::post('/course-type/store', [CourseTypeController::class, 'store'])->name('courseType.store');
        Route::get('/course-type/edit', [CourseTypeController::class, 'edit'])->name('courseType.edit');
        Route::post('course-type/destroy', [CourseTypeController::class, 'destroy'])->name('courseType.destroy');
    
        Route::resource('student', StudentController::class);
        Route::get('/cityGetStateWise', [StudentController::class, 'stateWiseCity'])->name('cityGetStateWise');
        Route::get('/getCity/{state_id}', [StudentController::class, 'getCity']);
        Route::get('/getCourse/{course_type_id}', [StudentController::class, 'getCourse']);
        Route::get('/getCourseDetails/{course_id}', [StudentController::class, 'getCourseDetails']);
        Route::post('/students/{id}/toggle-active', [StudentController::class, 'toggleActive'])->name('students.toggleActive');
        Route::post('/students/{id}/toggle-certificate', [StudentController::class, 'toggleCertificate'])->name('students.toggleCertificate');
        Route::get('/seats/{id}/history', [UserController::class, 'history'])->name('seats.history');
        Route::delete('/Customers/{Customers}', [UserController::class, 'destroy'])->name('customers.destroy');
    


    });
});

