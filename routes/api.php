<?php

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::name('pages.')->group(function () {
    Route::get('/services', [ApiController::class, 'services'])->name('services');
    Route::get('/employees', [ApiController::class, 'employees'])->name('employees');
    Route::get('/schedule', [ApiController::class, 'schedule'])->name('schedules');
    Route::get('/confirmation', [ApiController::class, 'confirmation'])->name('confirmation');
    Route::get('/finished-order', [ApiController::class, 'finishedOrder'])->name('finished-order');
});

Route::post('/save-step', [ApiController::class, 'saveProgress'])->name('save-step');
Route::post('/save-order', [ApiController::class, 'saveOrder'])->name('save-order');

