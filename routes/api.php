<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Middleware\TokenVerificationMiddleware;

// User Login
Route::post('/login-api', [UserController::class, 'login']);
Route::post('/create-user-api', [UserController::class, 'createUser'])
    ->middleware(TokenVerificationMiddleware::class);
