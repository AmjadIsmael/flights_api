<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\PassengerController;
use App\Http\Controllers\API\FlightController;
use App\Http\Controllers\API\FlightPassengerController;
use App\Http\Controllers\API\UserController;



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

Route::prefix('passengers')->group(function () {
    Route::get('/', [App\Http\Controllers\API\PassengerController::class, 'index'])->name('passengers.index');
});
Route::prefix('flights')->group(function () {
    Route::get('/', [App\Http\Controllers\API\FlightController::class, 'index'])->name('flights.index');
});
Route::get('/flights/{id}', [FlightController::class, 'show']);

Route::prefix('api')->group(function () {
    Route::apiResource('users', UserController::class);
});
