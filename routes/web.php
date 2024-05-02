<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\ReservationController;
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

Route::get('/', [BookingController::class, 'index']);

Route::name('pages.')->group(function () {
    Route::get('/services', [BookingController::class, 'services'])->name('services');
    Route::get('/employees', [BookingController::class, 'employees'])->name('employees');
    Route::get('/schedule', [BookingController::class, 'schedule'])->name('schedules');
    Route::get('/confirmation', [BookingController::class, 'confirmation'])->name('confirmation');
});

Route::get('/save-step', [ReservationController::class, 'saveProgress'])->name('save-step');
