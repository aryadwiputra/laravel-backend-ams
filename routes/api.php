<?php

use App\Http\Controllers\Api\V1\Admin\CompanyController;
use App\Http\Controllers\Api\V1\Admin\UserController;
use App\Http\Controllers\Api\V1\Auth\LoginController;
use App\Http\Controllers\Api\V1\Auth\RegisterController;
use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\Admin\UnitOfMeasurementController;
use App\Http\Middleware\JwtMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Authentication Routes
Route::prefix('v1/auth')->group(function () {
    Route::post('/register', RegisterController::class)->name('auth.register');
    Route::post('/login', LoginController::class)->name('auth.login'); // Ubah endpoint di sini
});

// Protected Routes (Requires Authentication)
Route::middleware([JwtMiddleware::class])->prefix('v1')->name('v1.')->group(function () {
    // Category Routes
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('users', UserController::class);
    Route::apiResource('companies', CompanyController::class);
    Route::apiResource('unit_of_measurements', UnitOfMeasurementController::class);

    // User Route (Example)
    Route::get('/user', function (Request $request) {
        return $request->user();
    })->name('user');
});