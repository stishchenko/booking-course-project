<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ProfileController;
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
Route::post('/save-order', [ReservationController::class, 'saveOrder'])->name('save-order');

//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
