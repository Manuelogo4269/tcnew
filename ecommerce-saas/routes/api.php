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

// Public Store Browsing & Services
Route::get('/stores', [MobileStoreController::class, 'index']);
Route::get('/stores/{tenant}/settings', [MobileStoreController::class, 'settings']);
Route::get('/stores/{tenant}/categories', [MobileStoreController::class, 'categories']);
Route::get('/stores/{tenant}/products', [MobileStoreController::class, 'products']);
Route::get('/stores/{tenant}/products/{product}', [MobileStoreController::class, 'showProduct']);
Route::post('/tienda/{tenant}/checkout', [\App\Http\Controllers\CheckoutController::class, 'processCheckout']);

// Services, Staff, Appointments & Memberships (Public & Guest access)
Route::get('/stores/{tenant}/services', [\App\Http\Controllers\AppointmentController::class, 'services']);
Route::get('/stores/{tenant}/staff', [\App\Http\Controllers\AppointmentController::class, 'staff']);
Route::get('/stores/{tenant}/appointments/available-slots', [\App\Http\Controllers\AppointmentController::class, 'availableSlots']);
Route::post('/stores/{tenant}/appointments', [\App\Http\Controllers\AppointmentController::class, 'book']);
Route::get('/stores/{tenant}/memberships/plans', [\App\Http\Controllers\AppointmentController::class, 'membershipPlans']);
Route::get('/stores/{tenant}/memberships/my-card', [\App\Http\Controllers\AppointmentController::class, 'myMembership']);
Route::post('/stores/{tenant}/push/subscribe', [\App\Http\Controllers\AppointmentController::class, 'subscribePush']);
Route::post('/stores/{tenant}/push/send-test', [\App\Http\Controllers\AppointmentController::class, 'sendTestPush']);

// Protected by Central Sanctum (Authenticated Mobile Customers)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/auth/logout', [MobileAuthController::class, 'logout']);
    Route::get('/user', fn (Request $request) => $request->user());

    // Tenant interaction & Orders
    Route::post('/stores/{tenant}/join', [MobileStoreController::class, 'join']);
    Route::post('/stores/{tenant}/orders', [MobileStoreController::class, 'createOrder']);
    Route::get('/stores/{tenant}/orders', [MobileStoreController::class, 'orders']);
    Route::get('/stores/{tenant}/orders/{order}', [MobileStoreController::class, 'showOrder']);

    // Authenticated Appointments & Memberships
    Route::get('/stores/{tenant}/appointments/my-appointments', [\App\Http\Controllers\AppointmentController::class, 'myAppointments']);
});
