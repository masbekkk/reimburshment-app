<?php

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

Route::get('/', function () {
    return view('layouts.index');
});

Route::middleware('auth')->group(function () {
    Route::resource('reimburshment', ReimburshmentController::class);
    Route::get('get-reimburshment', [ReimburshmentController::class, 'getReimburshment'])->name('reimburshment.get-data');
});

require __DIR__ . '/auth.php';
