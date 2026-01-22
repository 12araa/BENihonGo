<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\FlashcardController;
use App\Http\Controllers\Api\GameController;
use App\Http\Controllers\Api\PomodoroController;
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
    Route::post('/pomodoro/start', [PomodoroController::class, 'start']);
    Route::post('/pomodoro/stop', [PomodoroController::class, 'stop']);

    // --- SHOP ---
    Route::get('/shop', [ShopController::class, 'index']); // Lihat Toko
    Route::post('/shop/buy', [ShopController::class, 'buy']);   // Beli
    Route::post('/shop/equip', [ShopController::class, 'equip']); // Pakai

    // --- LEARNING (Stages & Flashcards) ---
    Route::get('/stages', [StageController::class, 'index']);
    Route::get('/stages/{id}', [StageController::class, 'show']);
    Route::get('/flashcards', [FlashcardController::class, 'index']);
    Route::get('/flashcards/{id}', [FlashcardController::class, 'show']);
});

Route::middleware(['auth:sanctum'])->prefix('admin')->group(function () {
    // URL: /api/admin/stages
    Route::post('/chapters', [AdminController::class, 'storeChapter']);
    Route::put('/chapters/{id}', [AdminController::class, 'updateChapter']);
    Route::delete('/chapters/{id}', [AdminController::class, 'destroyChapter']);
    Route::get('/chapters', [AdminController::class, 'indexChapters']);
    Route::get('/chapters/{id}', [AdminController::class, 'showChapter']);

    Route::post('/stages', [AdminController::class, 'storeStage']);
    Route::put('/stages/{id}', [AdminController::class, 'updateStage']);
    Route::delete('/stages/{id}', [AdminController::class, 'destroyStage']);
    Route::get('/stages', [AdminController::class, 'indexStages']);
    Route::get('/stages/{id}', [AdminController::class, 'showStage']);

    Route::post('/flashcards', [AdminController::class, 'storeFlashcard']);
    Route::put('/flashcards/{id}', [AdminController::class, 'updateFlashcard']);
    Route::delete('/flashcards/{id}', [AdminController::class, 'destroyFlashcard']);
    Route::get('/flashcards', [AdminController::class, 'indexFlashcards']);
    Route::get('/flashcards/{id}', [AdminController::class, 'showFlashcard']);

    Route::post('/quizzes', [AdminController::class, 'storeQuiz']);
    Route::put('/quizzes/{id}', [AdminController::class, 'updateQuiz']);
    Route::delete('/quizzes/{id}', [AdminController::class, 'destroyQuiz']);
    Route::get('/quizzes', [AdminController::class, 'indexQuizzes']);
    Route::get('/quizzes/{id}', [AdminController::class, 'showQuiz']);

    Route::post('/monsters', [AdminController::class, 'storeMonster']);
    Route::put('/monsters/{id}', [AdminController::class, 'updateMonster']);
    Route::delete('/monsters/{id}', [AdminController::class, 'destroyMonster']);
    Route::get('/monsters', [AdminController::class, 'indexMonsters']);
    Route::get('/monsters/{id}', [AdminController::class, 'showMonster']);
});
