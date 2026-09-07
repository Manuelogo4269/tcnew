<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MobileAuthController;
use App\Http\Controllers\MobileStoreController;

Route::prefix('auth')->group(function () {
    Route::post('/register', [MobileAuthController::class, 'register']);
    Route::post('/login', [MobileAuthController::class, 'login']);
    Route::middleware('auth:sanctum')->post('/logout', [MobileAuthController::class, 'logout']);
});

Route::get('/stores', [MobileStoreController::class, 'index']);
Route::get('/stores/{tenant}/products', [MobileStoreController::class, 'products']);
Route::middleware('auth:sanctum')->post('/stores/{tenant}/join', [MobileStoreController::class, 'join']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
