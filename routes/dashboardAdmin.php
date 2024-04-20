<?php

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

use App\Http\Controllers\DashboardAdmin\GenerationController;
use App\Http\Controllers\DashboardAdmin\RestaurantController;
use Illuminate\Support\Facades\Route;

Route::get('RestaurantByUuid/{restaurant:uuid}', [RestaurantController::class, 'RestaurantByUuid']);
Route::middleware(['auth:sanctum', 'abilities:admin'])->group(function () {
    Route::apiResource('restaurant', RestaurantController::class);
    Route::post('storeRestaurantsByNumber', [RestaurantController::class, 'storeRestaurantsByNumber']);
    Route::post('generation', [GenerationController::class, 'store']);
    Route::put('create_value', [GenerationController::class, 'create_value']);
});
Route::get('get_value_for_Link', [GenerationController::class, 'show']);
