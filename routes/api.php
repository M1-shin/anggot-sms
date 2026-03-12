<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\ScholarshipController;
use App\Http\Controllers\Api\ApplicationController;
use App\Http\Controllers\Api\AuthController;

Route::post('/student', [StudentController::class, 'store']); 
Route::get('/student', [StudentController::class, 'index']);  
Route::get('/student/{id}', [StudentController::class, 'show']);  
Route::put('/student/{id}', [StudentController::class, 'update']); 
Route::delete('/student/{id}', [StudentController::class, 'destroy']);

Route::post('/scholarship', [ScholarshipController::class, 'store']); 
Route::get('/scholarship', [ScholarshipController::class, 'index']); 
Route::get('/scholarship/{id}', [ScholarshipController::class, 'show']); 
Route::put('/scholarship/{id}', [ScholarshipController::class, 'update']); 
Route::delete('/scholarship/{id}', [ScholarshipController::class, 'destroy']);

Route::post('/application', [ApplicationController::class, 'store']);
Route::get('/application', [ApplicationController::class, 'index']);
Route::get('/application/{id}', [ApplicationController::class, 'show']);
Route::put('/application/{id}', [ApplicationController::class, 'update']);
Route::delete('/application/{id}', [ApplicationController::class, 'destroy']);

Route::post('/register', [AuthController::class,'register']);
Route::post('/login', [AuthController::class,'login']);
Route::post('/logout', [AuthController::class,'logout']);

Route::put('/application/{id}/approve', [ApplicationController::class,'approve']);
Route::put('/application/{id}/reject', [ApplicationController::class,'reject']);

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
