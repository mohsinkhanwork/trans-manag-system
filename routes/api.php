<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TranslationController;
use App\Http\Controllers\AuthController;

// Public routes
Route::post('login', [AuthController::class, 'login']);

// Protected routes
Route::middleware('auth:sanctum')->group(function() {
    // Authentication
    Route::post('logout', [AuthController::class, 'logout']);
    
    // Translations CRUD
    Route::apiResource('translations', TranslationController::class);
    
    // Translations search/export
    Route::prefix('translations')->group(function () {
        Route::get('search/key/{key}', [TranslationController::class, 'searchByKey']);
        Route::get('search/tag/{tag}', [TranslationController::class, 'searchByTag']);
        Route::get('search/content/{content}', [TranslationController::class, 'searchByContent']);
        Route::get('export/json', [TranslationController::class, 'exportJson']);
        Route::get('export/json/{locale}', [TranslationController::class, 'exportJson']);
    });
});