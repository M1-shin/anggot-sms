<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\StudentController;
use App\Http\Controllers\API\ScholarshipController;
use App\Http\Controllers\API\ApplicationController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

    // ADMIN + SECRETARY
    Route::middleware('role:admin,secretary')->group(function () {

        // Applicants
        Route::apiResource('student', StudentController::class);

        // Scholarships
        Route::apiResource('scholarship', ScholarshipController::class);

        // Applications
        Route::get('/application', [ApplicationController::class, 'index']);
        Route::post('/application/{id}/approve', [ApplicationController::class, 'approve']);
        Route::post('/application/{id}/reject', [ApplicationController::class, 'reject']);
    });

    // STUDENT ONLY
    Route::middleware('role:student')->group(function () {

        Route::get('/scholarship', [ScholarshipController::class, 'index']);

        Route::post('/apply', [ApplicationController::class, 'apply']);
        Route::get('/my-application', [ApplicationController::class, 'myApplications']);
        Route::put('/application/{id}', [ApplicationController::class, 'update']);
        Route::delete('/application/{id}', [ApplicationController::class, 'destroy']);
    });
});