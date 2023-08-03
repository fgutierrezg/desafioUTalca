<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use L5Swagger\Http\Controllers\SwaggerController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/* 
Route::apiResource('users', UserController::class); */

// Ruta para obtener todos los usuarios
Route::get('/users/list', [UserController::class, 'index']);

// Ruta para obtener un usuario por ID
Route::get('/users/{id}', [UserController::class, 'show']);

// Ruta para crear un nuevo usuario
Route::post('/users/new', [UserController::class, 'store']);

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

//protected

Route::middleware('jwt.verify')->group(function () {
    
    Route::delete('/users/delete/{id}', [UserController::class, 'destroy']);
    Route::put('/users/me/{id}', [UserController::class, 'update']);
    Route::get('/documentation', [SwaggerController::class, 'api']);
    Route::get('/users/list', [UserController::class, 'index']);
    
});