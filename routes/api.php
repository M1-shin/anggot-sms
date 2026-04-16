ROUTES

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\StudentController;
use App\Http\Controllers\API\ScholarshipController;
use App\Http\Controllers\API\ApplicationController;

// PUBLIC
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// AUTHENTICATED USERS
Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/scholarship', [ScholarshipController::class, 'index']);

    // ADMIN + SECRETARY
    Route::middleware('role:admin,secretary')->group(function () {

        // Students
        Route::apiResource('student', StudentController::class);

        // Scholarships (only admin/secretary can modify)
        Route::post('/scholarship', [ScholarshipController::class, 'store']);
        Route::put('/scholarship/{id}', [ScholarshipController::class, 'update']);
        Route::delete('/scholarship/{id}', [ScholarshipController::class, 'destroy']);

        // Applications
        Route::post('/application', [ApplicationController::class, 'store']);
        Route::get('/application', [ApplicationController::class, 'index']);
        Route::post('/application/{id}/approve', [ApplicationController::class, 'approve']);
        Route::post('/application/{id}/reject', [ApplicationController::class, 'reject']);
    });


    // STUDENT ONLY
    Route::middleware('role:student')->group(function () {

        Route::post('/apply', [ApplicationController::class, 'apply']);
        Route::get('/my-application', [ApplicationController::class, 'myApplications']);
        Route::put('/application/{id}', [ApplicationController::class, 'update']);
        Route::delete('/application/{id}', [ApplicationController::class, 'destroy']);
    });
});