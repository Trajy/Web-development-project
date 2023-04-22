<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EmployerController;
use App\Http\Controllers\EmploymentController;

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

Route::resource('employments', EmploymentController::class)->only(['index', 'show']);
Route::middleware(['auth:sanctum', 'ability:employee,employer'])->group(function () {
    Route::get('me', [EmploymentController::class, 'showMe']);
});
Route::middleware(['auth:sanctum', 'ability:employer'])->group(function () {
    Route::resource('employments' ,EmploymentController::class)->except(['index', 'show']);
});

Route::prefix('auth')->group(function () {
    Route::post('register', [EmployeeController::class, 'register']);
    Route::post('employer/register', [EmployerController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('me', [AuthController::class, 'user']);
        Route::delete('logout', [AuthController::class, 'logout']);
    });
});
