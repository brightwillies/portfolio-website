<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\MyaccountController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

//Cart
Route::controller(CartController::class)->group(function () {
    Route::group(['prefix' => 'cart'], function () {
        Route::post('/add-item', 'addItem');
        Route::post('/reduce-item', 'reduceItem');
    });
    Route::group(['prefix' => 'cartpage'], function () {
        Route::post('/add-item', 'addItemCartPage');
        Route::post('/reduce-item', 'reduceItemCartPage');
        Route::post('/delete-row', 'removeRow');
    });
    Route::get('/check-product/{productId}', 'findOutIfProductIsInCart');
    Route::get('/get-cart-items-table', 'getCartProductTable');
});


//wishlist function
Route::controller(WishlistController::class)->group(function () {
    Route::group(['prefix' => 'wishlist'], function () {
        Route::post('/add-item', 'addItem');
        Route::post('/remove-item', 'removeItem');
    });
});

//search
Route::controller(SearchController::class)->group(function () {
    Route::group(['prefix' => 'search'], function () {
        Route::post('/', 'searchItem');
        Route::post('/reduce-item', 'reduceItem');
        Route::post('/find-item', 'findItem');
    });

});
Route::controller(MyaccountController::class)->group(function () {
    Route::group(['prefix' => 'dashboard'], function () {
        Route::post('/get-order-details', 'getOrderDetails');
    });

});
