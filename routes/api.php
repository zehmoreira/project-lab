<?php

use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('forgot-password', [AuthController::class, 'sendCodeNewPassword']);
Route::post('reset-password', [AuthController::class, 'resetPassword']);

Route::middleware('auth:api')->group(function () {
    Route::prefix('me')->group(function () {
        Route::put('profile', [ProfileController::class, 'update']);
        Route::put('change-picture', [ProfileController::class, 'changePicture']);
        Route::get('profile', [ProfileController::class, 'show']);
    });

    Route::get('/', function () {
        return 'root';
    });
});
