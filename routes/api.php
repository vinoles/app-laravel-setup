<?php

use App\Http\Controllers\Api\V1\Auth\ConfirmPasswordController;
use App\Http\Controllers\Api\V1\Auth\LoginController;
use App\Http\Controllers\Api\V1\Auth\RegisterController;
use App\Http\Controllers\Api\V1\TalentController;
use Illuminate\Support\Facades\Route;
use LaravelJsonApi\Laravel\Facades\JsonApiRoute;
use LaravelJsonApi\Laravel\Routing\ResourceRegistrar;

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

Route::middleware('auth:sanctum')->group(static function () {
    JsonApiRoute::server('v1')
        ->prefix('v1')
        ->name('v1.api.')
        ->resources(static function (ResourceRegistrar $server) {
            $server->resource('talents', TalentController::class);

            Route::prefix('auth')->group(static function () {
                Route::post('confirm-password/{user}', ConfirmPasswordController::class)
                    ->name('auth.password.confirm');
            });
        });
});

JsonApiRoute::server('v1')
    ->prefix('v1/auth')
    ->resources(static function () {
        Route::post('login', LoginController::class)->name('api.auth.login');
        Route::post('register', RegisterController::class)->name('api.auth.register');
    });
