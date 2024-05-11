<?php

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ReimburshmentController;
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
        return view('layouts.index');
    });
    Route::resource('reimburshment', ReimburshmentController::class);
    Route::get('get-reimburshment', [ReimburshmentController::class, 'getReimburshment'])->name('reimburshment.get-data');
    Route::post('reimburshment/update-status', [ReimburshmentController::class, 'updateStatus'])->name('reimburshment.update-status');

    Route::resource('employees', EmployeeController::class)->middleware('role:direktur');
    Route::get('get-employees', [EmployeeController::class, 'getEmployees'])->name('employees.get-data')->middleware('role:direktur');
});

require __DIR__ . '/auth.php';
