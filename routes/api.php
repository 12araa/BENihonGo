<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\FlashcardController;
use App\Http\Controllers\Api\GameController;
use App\Http\Controllers\Api\ShopController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\StageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {

    // --- AUTH (Logout) ---
    Route::post('/logout', [AuthController::class, 'logout']);

    // --- USER & DASHBOARD ---
    Route::get('/user', [UserController::class, 'me']);
    Route::put('/profile', [UserController::class, 'updateProfile']);
    Route::post('/onboarding', [UserController::class, 'submitOnboarding']);
    Route::get('/inventory', [UserController::class, 'inventory']);
    Route::get('/histories', [UserController::class, 'history']);
    Route::get('/leaderboard', [UserController::class, 'leaderboard']);

    // --- GAMEPLAY (Battle) ---
    Route::get('/game/start/{id}', [GameController::class, 'startGame']);
    Route::post('/game/finish', [GameController::class, 'finishGame']);

    // --- POMODORO ---
    // Route::post('/pomodoro', [PomodoroController::class, 'store']); // Simpan log fokus

    // --- SHOP ---
    Route::get('/shop', [ShopController::class, 'index']); // Lihat Toko
    Route::post('/shop/buy', [ShopController::class, 'buy']);   // Beli
    Route::post('/shop/equip', [ShopController::class, 'equip']); // Pakai

    // --- LEARNING (Stages & Flashcards) ---
    // Kita kunci juga biar user harus login buat belajar (opsional, tapi disarankan)
    Route::get('/stages', [StageController::class, 'index']);
    Route::get('/stages/{id}', [StageController::class, 'show']);
    Route::get('/flashcards', [FlashcardController::class, 'index']);
    Route::get('/flashcards/{id}', [FlashcardController::class, 'show']);

    // --- ADMIN ROUTES (Nanti Minggu ke-2) ---
    // Route::prefix('admin')->group(function () {
    //     Route::post('/stages', [AdminController::class, 'storeStage']);
    //     // ... rute admin lainnya ...
    // });

});
