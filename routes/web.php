<?php

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\VehicleLoanController;
use App\Http\Controllers\RolesController;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return redirect()->route('vehicle-loan.index');
        // return view('layouts.index');
    });
    Route::resource('vehicle-loan', VehicleLoanController::class);
    Route::get('get-vehicle-loan', [VehicleLoanController::class, 'getVehicleLoan'])->name('vehicle-loan.get-data');
    Route::post('vehicle-loan/update-status', [VehicleLoanController::class, 'updateStatus'])->name('vehicle-loan.update-status');

    Route::middleware('role:direktur')->group(function () {
        Route::resource('employees', EmployeeController::class);
        Route::get('get-employees', [EmployeeController::class, 'getEmployees'])->name('employees.get-data');

        Route::resource('roles', RolesController::class);
        Route::get('get-roles', [RolesController::class, 'getRoles'])->name('roles.get-data');

        Route::resource('permissions', PermissionController::class);
    });
});

require __DIR__ . '/auth.php';
