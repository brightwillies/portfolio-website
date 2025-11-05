<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FrontendController;


use Illuminate\Support\Facades\Route;

//

// landing Pages
Route::get('/', [FrontendController::class, 'index'])->name('home');

//Product
Route::get('/product/ajax/{ProductId}', [ProductController::class, 'getProduct']);

//Administrator dashboard
Route::get('/administrator-login', [DashboardController::class, 'adminLogin']);
Route::get('/administrator-dashboard', [DashboardController::class, 'adminDashboard']);
Route::get('/administrator-dashboard/{any?}', [DashboardController::class, 'adminDashboard']);
Route::get('/administrator-dashboard/project/{any?}', [DashboardController::class, 'adminDashboard']);
