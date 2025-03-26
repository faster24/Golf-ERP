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

        Route::post('/google/signIn', 'oauthLogin');

        Route::middleware('auth:sanctum')->group(function () {
            Route::get('/user', 'user');
            Route::put('/user', 'update');
            Route::post('/logout', 'logout');
            Route::post('/logout-all', 'logoutAll');
        });
    });

    Route::prefix('courses')->controller(CourseController::class)->group(function() {
        Route::get('/featured' , 'getFeaturedCourses');
    });

    Route::apiResource('courses', CourseController::class);

    Route::prefix('packages')->controller(PackageController::class)->group(function() {
        Route::get('/' , 'index');
    });

    Route::middleware('auth:sanctum')->group(function() {

        Route::prefix('bookings')->controller(BookingController::class)->group(function() {
            Route::get('/{customer_id}/customer' , 'getBookingByCustomer');
            Route::get('/{bookingId}/cancel' , 'cancelBooking');
            Route::get('/cancel/{customer_id}/customer' , 'getCancelBookingByCustomer');
        });

        Route::apiResource('bookings', BookingController::class);

        Route::prefix('attendee')->controller(AttendeeController::class)->group(function() {
            Route::post('/create' , 'store');
        });

        Route::prefix('network')->controller(CustomerController::class)->group(function() {
            Route::get('/' , 'index');
        });
    });
});
