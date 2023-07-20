<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\TravelController;
use App\Http\Controllers\TravelOrderController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', [AuthController::class, 'userRegister']);

Route::post('login', [AuthController::class, 'userLogin']);

Route::post('logout', [AuthController::class, 'userLogout'])->middleware(['auth:sanctum']);

Route::post('update-profile', [AuthController::class, 'updateProfile'])->middleware(['auth:sanctum']);

Route::get('travel-lists', [TravelController::class, 'allTravel'])->middleware(['auth:sanctum']);
Route::get('travel-lists/filter', [TravelController::class, 'filterTravel'])->middleware(['auth:sanctum']);

Route::post('travel/order', [TravelOrderController::class, 'createOrder'])->middleware('auth:sanctum');

