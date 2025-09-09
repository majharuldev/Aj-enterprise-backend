<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\FuelController;
use App\Http\Controllers\Api\V1\TripController;
use App\Http\Controllers\Api\V1\PartsController;
use App\Http\Controllers\Api\V1\DriverController;
use App\Http\Controllers\Api\V1\VehicleController;
use App\Http\Controllers\Api\V1\MaintainceController;
use App\Http\Controllers\Api\V1\DailyExpenseController;
use App\Http\Controllers\Api\V1\EmployeeController;
use App\Http\Controllers\Api\V1\HelperController;

Route::prefix('v1')->group(function () {

    // Public Routes (No auth needed)
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    // Protected Routes (Need Sanctum auth)
    Route::middleware('auth:sanctum')->group(function () {

        // User info & logout
        Route::get('/user', function (Request $request) {
            return $request->user();
        });
        Route::post('/logout', [AuthController::class, 'logout']);

        // CRUD routes for resources using apiResource (auto routes for index, show, store, update, destroy)


        // daily expense
        Route::apiResource('payments', DailyExpenseController::class);

        // parts route
        Route::apiResource('parts', PartsController::class);

        // mainataince
        Route::apiResource('maintaince', MaintainceController::class);

        // fuel 
        Route::apiResource('fuel', FuelController::class);

        // vehicle
        Route::apiResource('vehicle', VehicleController::class);

        // trip
        Route::apiResource('trip', TripController::class);
        
        // driver
        Route::apiResource('driver', DriverController::class);

        // helper
        Route::apiResource('helper', HelperController::class);

        // employee
        Route::apiResource('employee', EmployeeController::class);
    });
});
