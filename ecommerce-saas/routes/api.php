<?php

use App\Http\Controllers\MobileAuthController;
use App\Http\Controllers\MobileStoreController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Mobile App API Routes
|--------------------------------------------------------------------------
|
| Central authentication with Laravel Sanctum and tenant-isolated operations.
|
*/

// Public Authentication
Route::prefix('auth')->group(function () {
    Route::post('/register', [MobileAuthController::class, 'register']);
    Route::post('/login', [MobileAuthController::class, 'login']);
});

// Public Store Browsing
Route::get('/stores', [MobileStoreController::class, 'index']);
Route::get('/stores/{tenant}/settings', [MobileStoreController::class, 'settings']);
Route::get('/stores/{tenant}/categories', [MobileStoreController::class, 'categories']);
Route::get('/stores/{tenant}/products', [MobileStoreController::class, 'products']);
Route::get('/stores/{tenant}/products/{product}', [MobileStoreController::class, 'showProduct']);

// Protected by Central Sanctum (Authenticated Mobile Customers)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/auth/logout', [MobileAuthController::class, 'logout']);
    Route::get('/user', fn (Request $request) => $request->user());

    // Tenant interaction & Orders
    Route::post('/stores/{tenant}/join', [MobileStoreController::class, 'join']);
    Route::post('/stores/{tenant}/orders', [MobileStoreController::class, 'createOrder']);
    Route::get('/stores/{tenant}/orders', [MobileStoreController::class, 'orders']);
    Route::get('/stores/{tenant}/orders/{order}', [MobileStoreController::class, 'showOrder']);
});
