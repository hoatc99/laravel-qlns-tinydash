<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\TimesheetController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\PayoffController;
use App\Http\Controllers\AdvanceController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LaborContractController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\InsurancePayController;

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

Route::get('login', [HomeController::class, 'login'])->name('login');
Route::post('login', [HomeController::class, 'authenticate'])->name('authenticate');
Route::post('forgot', [HomeController::class, 'confirm'])->name('confirm');
Route::get('forgot', [HomeController::class, 'forgot'])->name('forgot');

Route::middleware('auth')->group(function () {
    Route::get('', [HomeController::class, 'index'])->name('home');
    Route::get('logout', [HomeController::class, 'logout'])->name('logout');

    Route::middleware('role:admin')->group(function () {
        Route::post('settings', [HomeController::class, 'save_settings'])->name('save_settings');
        Route::get('settings', [HomeController::class, 'settings'])->name('settings');
    });

    Route::middleware('role:admin,hr')->group(function () {
        Route::post('employees/{employee:id}/update_status', [EmployeeController::class, 'update_status'])->name('employees.update_status');
        Route::post('employees/{employee:id}/assign', [EmployeeController::class, 'assign'])->name('employees.assign');
        Route::get('employees/all/print', [EmployeeController::class, 'print_all'])->name('employees.print_all');
        Route::get('employees/{employee:id}/print', [EmployeeController::class, 'print_single'])->name('employees.print_single');
        Route::resource('employees', EmployeeController::class)->names('employees')->except(['destroy']);

        Route::post('timesheets/close', [TimesheetController::class, 'close_timesheets'])->name('timesheets.close');
        Route::get('timesheets/close', [TimesheetController::class, 'show_timesheets_to_close'])->name('timesheets.show_timesheets_to_close');
        Route::post('timesheets/timekeeping', [TimesheetController::class, 'send_timekeeping_request'])->name('timesheets.send_timekeeping_request');
        Route::get('timesheets/timekeeping', [TimesheetController::class, 'timekeeping'])->name('timesheets.timekeeping');
        Route::get('timesheets/print', [TimesheetController::class, 'print'])->name('timesheets.print');
        Route::resource('timesheets', TimesheetController::class)->names('timesheets');

        Route::resource('labor-contracts', LaborContractController::class)->names('labor-contracts')->only([
            'index', 'store', 'update'
        ]);

        Route::resource('departments', DepartmentController::class)->names('departments')->only([
            'index', 'store', 'update'
        ]);

        Route::resource('positions', PositionController::class)->names('positions')->only([
            'index', 'store', 'update'
        ]);
    });

    Route::middleware('role:admin,accounting')->group(function () {
        Route::post('payrolls/calculate', [PayrollController::class, 'send_calculate_request'])->name('payrolls.send_calculate_request');
        Route::get('payrolls/calculate', [PayrollController::class, 'calculate'])->name('payrolls.calculate');
        Route::get('payrolls/print', [PayrollController::class, 'print'])->name('payrolls.print');
        Route::resource('payrolls', PayrollController::class)->names('payrolls');

        Route::resource('insurance-pays', InsurancePayController::class)->names('insurance-pays')->only([
            'index'
        ]);

        Route::resource('payoffs', PayoffController::class)->names('payoffs')->only([
            'index', 'store', 'update', 'destroy'
        ]);

        Route::resource('advances', AdvanceController::class)->names('advances')->only([
            'index', 'store', 'update', 'destroy'
        ]);
    });

    Route::middleware('role:admin,it')->group(function () {
        Route::post('users/{user:id}/lock', [UserController::class, 'lock'])->name('users.lock');
        Route::post('users/{user:id}/unlock', [UserController::class, 'unlock'])->name('users.unlock');
        Route::post('users/{user:id}/permission', [UserController::class, 'set_permission'])->name('users.set_permission');
        Route::resource('users', UserController::class)->names('users')->only([
            'index', 'store', 'update'
        ]);
    });
});
