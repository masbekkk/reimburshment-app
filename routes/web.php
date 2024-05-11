<?php

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ReimburshmentController;
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
        return redirect()->route('reimburshment.index');
        // return view('layouts.index');
    });
    Route::resource('reimburshment', ReimburshmentController::class);
    Route::get('get-reimburshment', [ReimburshmentController::class, 'getReimburshment'])->name('reimburshment.get-data');
    Route::post('reimburshment/update-status', [ReimburshmentController::class, 'updateStatus'])->name('reimburshment.update-status');

    Route::middleware('role:direktur')->group(function () {
        Route::resource('employees', EmployeeController::class);
        Route::get('get-employees', [EmployeeController::class, 'getEmployees'])->name('employees.get-data');

        Route::resource('roles', RolesController::class);
        Route::get('get-roles', [RolesController::class, 'getRoles'])->name('roles.get-data');
    });
});

require __DIR__ . '/auth.php';
