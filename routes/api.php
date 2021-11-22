<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\Auth\UserAuthController;

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

Route::prefix('v1')->group(function () {
    Route::post('users/register', [UserAuthController::class, 'register']);
    Route::post('users/login', [UserAuthController::class, 'login']);

    Route::middleware(['auth:sanctum'])->group(function () {
        Route::post('users/logout', [UserAuthController::class, 'logout']);

        Route::get('/users', [\App\Http\Controllers\Api\V1\UserController::class, 'index']);
    });
});
