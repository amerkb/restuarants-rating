<?php

use App\Http\Controllers\DashboardRestaurant\BackgroundController;
use App\Http\Controllers\DashboardRestaurant\DetailController;
use App\Http\Controllers\DashboardRestaurant\LogoController;
use App\Http\Controllers\DashboardRestaurant\MealController;
use App\Http\Controllers\DashboardRestaurant\ServiceController;
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
Route::middleware(['checkUser:restaurant'])->group(function () {
    Route::apiResource('meal', MealController::class)->except('update');
    Route::post('meal/{meal:id}', [MealController::class, 'update']);
    Route::apiResource('service', ServiceController::class);
    Route::get('logo', [LogoController::class, 'show']);
    Route::post('logo', [LogoController::class, 'store']);
    Route::post('logoUpdate', [LogoController::class, 'update']);
    Route::delete('logo', [LogoController::class, 'destroy']);
    Route::get('background', [BackgroundController::class, 'show']);
    Route::post('background', [BackgroundController::class, 'store']);
    Route::post('backgroundUpdate', [BackgroundController::class, 'update']);
    Route::delete('background', [BackgroundController::class, 'destroy']);
    Route::post('detail', [DetailController::class, 'store']);
    Route::put('detail', [DetailController::class, 'update']);

});
