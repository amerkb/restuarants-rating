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

use App\Http\Controllers\DashboardAdmin\RestaurantController;
use Illuminate\Support\Facades\Route;

Route::get('RestaurantByUuid/{restaurant:uuid}', [RestaurantController::class, 'RestaurantByUuid']);
Route::middleware(['checkUser:admin'])->group(function () {
    Route::apiResource('restaurant', RestaurantController::class);
    Route::post('storeRestaurantsByNumber', [RestaurantController::class, 'storeRestaurantsByNumber']);
});
