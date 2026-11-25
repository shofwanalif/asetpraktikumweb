<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\MemberController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    // Public
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);

    // Protected
    Route::middleware('auth:api')->group(function () {
        Route::get('me', [AuthController::class, 'me']);
        Route::post('logout', [AuthController::class, 'logout']);
    });
});

// Public: book catalog
Route::apiResource('books', BookController::class)->only(['index', 'show']);

// Protected: carrying JWT token
Route::middleware('auth:api')->group(function () {
    Route::apiResource('books', BookController::class)->except(['index', 'show']);

    Route::prefix('members')->group(function () {
        Route::post('{member}/borrow-book', [MemberController::class, 'borrowBook']);
        Route::patch('{member}/return-book/{book}', [MemberController::class, 'returnBook']);
    });

    Route::apiResource('members', MemberController::class);
});
