<?php

use Illuminate\Http\Request;
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

Route::resources(['employments' => EmploymentController::class,])->only(['index']);

Route::group(['middleware' => 'auth:sanctum'], function() {
    Route::resources([
        'employments' => EmploymentController::class,
    ]);
});

Route::prefix('auth')->group(function () {
    Route::post('register', [EmployeeController::class, 'register']);
    Route::post('employer/register', [EmployerController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('user', [AuthController::class, 'user']);
        Route::delete('logout', [AuthController::class, 'logout']);
    });
});
