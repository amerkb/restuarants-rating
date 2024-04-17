<?php

use App\Http\Controllers\DashboardRestaurant\AdditionController;
use App\Http\Controllers\DashboardRestaurant\BackgroundController;
use App\Http\Controllers\DashboardRestaurant\DetailController;
use App\Http\Controllers\DashboardRestaurant\LogoController;
use App\Http\Controllers\DashboardRestaurant\ServiceController;
use App\Http\Controllers\DashboardRestaurant\UserController;
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
    Route::apiResource('addition', AdditionController::class);
    Route::get('chartAddition', [AdditionController::class, 'chartAddition']); //chart columns sub
    Route::get('tableAddition', [AdditionController::class, 'tableAddition']); //table
    Route::get('avgAddition', [AdditionController::class, 'avgAddition']); //qvg
    Route::apiResource('service', ServiceController::class);
    Route::get('chartService', [ServiceController::class, 'chartService']); //chart columns services
    Route::get('tableServicesWithoutSub', [ServiceController::class, 'tableServicesWithoutSub']);
    Route::get('avgService', [ServiceController::class, 'avgService']); //avg
    Route::get('getUser', [UserController::class, 'getUser']); // user count status
    Route::get('logo', [LogoController::class, 'show']);
    Route::post('logo', [LogoController::class, 'store']);
    Route::post('logoUpdate', [LogoController::class, 'update']);
    Route::delete('logo', [LogoController::class, 'destroy']);
    Route::get('background', [BackgroundController::class, 'show']);
    Route::post('background', [BackgroundController::class, 'store']);
    Route::post('backgroundUpdate', [BackgroundController::class, 'update']);
    Route::delete('background', [BackgroundController::class, 'destroy']);
    Route::post('detail', [DetailController::class, 'store']);
    Route::put('detail', [DetailController::class, 'store']);
    Route::put('changeStatus', [DetailController::class, 'changeStatus']); // update status
    //edit

});
Route::get('a', [ServiceController::class, 'a']);
