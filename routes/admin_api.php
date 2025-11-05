<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

use App\Http\Controllers\Api\Admin\RolesController;
use App\Http\Controllers\Api\Admin\CategoryController;

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

Route::group(['prefix' => 'v1'], function () {

    Route::group(['prefix' => 'auth'], function () {
        Route::get('/{id}', [AuthController::class, 'getDetails']);
        Route::post('passwordreset', [AuthController::class, 'resetPassword']);
        Route::post('/update/{id}', [AuthController::class, 'UpdateAdmin']);
        Route::post('/login', [AuthController::class, 'adminLogin']);
    });

    Route::controller(RolesController::class)->group(function () {
        Route::group(['prefix' => 'role'], function () {
            Route::get('/', 'index');
            Route::get('/{id}', 'show');
            Route::post('/', 'store');
            Route::post('/{id}', 'update');
            Route::delete('/{id}', 'destroy');
        });
    });
    Route::controller(CategoryController::class)->group(function () {
        Route::group(['prefix' => 'category'], function () {
            Route::get('/', 'index');
            Route::get('/{id}', 'show');
            Route::post('/', 'store');
            Route::post('/{id}', 'update');
            Route::delete('/{id}', 'destroy');
        });
    });



});
