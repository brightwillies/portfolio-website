<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\Api\Mobile\AuthController;
use App\Http\Controllers\Api\Mobile\CartController;
use App\Http\Controllers\Api\Mobile\OrderController;
use App\Http\Controllers\Api\Mobile\ProductAndCategoriesController;

/*
|--------------------------------------------------------------------------
| MOBILE API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

Route::group(['prefix' => 'v1'], function () {

    //Authentication pages items
    Route::controller(AuthController::class)->group(function () {
        Route::group(['prefix' => 'authentication'], function () {
            Route::post('/register', 'storeRegistration')->name('register');
            Route::post('/login', 'login')->name('login');
            Route::post('/verify-code', 'verifyCode')->name('codeverification');
            Route::post('/forgot-password', 'forgotPassword')->name('forgot-password');
        });

    });
    Route::controller(ProductAndCategoriesController::class)->group(function () {
        Route::group(['prefix' => 'catalogue'], function () {
            Route::get('/regions', 'regions');
            Route::get('/cities', 'cities');
            Route::get('/categories/{cityId}', 'categories');
            Route::get('/category/{cityId}/{categoryId}', 'fetchCategoryProducts');
            Route::get('/homecategories/{cityId}', 'homeCategories');
            Route::get('/sliders', 'sliders');
        });
    });
    
    Route::controller(CartController::class)->group(function () {
        Route::group(['prefix' => 'cart'], function () {
            Route::post('/add-item', 'addItem');
            Route::post('/reduce-item', 'reduceItem');
            Route::get('/data/{customerMask}/{cityMask}', 'getCartData');
            Route::get('/total-items/{customerMask}/{cityMask}', 'getCartTotalByApi');
            Route::post('/delete-row', 'removeRow');
        });
    });

    // Cat operations
    Route::controller(OrderController::class)->group(function () {
        Route::group(['prefix' => 'order'], function () {
            Route::get('/{customerMask}/{cityMask}', 'index');
            Route::post('/', 'store');
        });
    });
    // search for a product
    Route::controller(SearchController::class)->group(function () {
        Route::group(['prefix' => 'search'], function () {
            Route::post('/', 'searchOnMobile');
        });
    });

});
