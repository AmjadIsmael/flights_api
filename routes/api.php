<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\PassengerController;
use App\Http\Controllers\API\FlightController;
use App\Http\Controllers\API\FlightPassengerController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\AuthController;


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





Route::middleware(['auth:sanctum', 'role:super-admin'])->group(function () {
    Route::apiResource('users', UserController::class);
    Route::apiResource('flights', FlightController::class);
    Route::apiResource('passengers', PassengerController::class);
});


Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1', 'role:super-admin');
Route::post('/register', [AuthController::class, 'register'])->middleware('role:super-admin');
Route::post('/logout', [AuthController::class, 'logout'])->middleware(['auth:sanctum', 'role:super-admin']);

Route::get('/users/export', [UserController::class, 'exportToExcel'])->name('users.export');
