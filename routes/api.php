<?php

use App\Http\Controllers\Api\AttendeeController;
use App\Http\Controllers\Api\CustomerController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\PackageController;

Route::prefix('v1')->group(function () {

    Route::controller(AuthController::class)->group(function () {
        Route::post('/register', 'register');
        Route::post('/login', 'login');

        Route::middleware('auth:sanctum')->group(function () {
            Route::get('/user', 'user');
            Route::put('/user', 'update');
            Route::post('/logout', 'logout');
            Route::post('/logout-all', 'logoutAll');
        });
    });

    Route::middleware('auth:sanctum')->group(function() {
        Route::apiResource('courses', CourseController::class);
        Route::apiResource('bookings', BookingController::class);

        Route::prefix('bookings')->controller(BookingController::class)->group(function() {
            Route::get('/{customer_id}/customer' , 'getBookingByCustomer');
            Route::get('/{bookingId}/cancel' , 'cancelBooking');
            Route::get('/{customer_id}/customer' , 'getCancelBookingByCustomer');
        });

        Route::prefix('attendee')->controller(AttendeeController::class)->group(function() {
            Route::post('/create' , 'store');
        });

        Route::prefix('packages')->controller(PackageController::class)->group(function() {
            Route::get('/' , 'index');
        });

        Route::prefix('network')->controller(CustomerController::class)->group(function() {
            Route::get('/' , 'index');
        });
    });
});
