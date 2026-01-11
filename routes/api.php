<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\FlashcardController;
use App\Http\Controllers\Api\GameController;
use App\Http\Controllers\Api\ShopController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\StageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

// --- GAMEPLAY ---
Route::get('/game/start/{id}', [GameController::class, 'startGame']);
Route::post('/game/finish', [GameController::class, 'finishGame']);

// --- STAGES / MAP ---
Route::get('/stages', [StageController::class, 'index']);
Route::get('/stages/{id}', [StageController::class, 'show']);

// --- USER & DASHBOARD ---
Route::get('/user', [UserController::class, 'me']);
Route::get('/histories', [UserController::class, 'history']);

// --- FLASHCARDS / DICTIONARY ---
Route::get('/flashcards', [FlashcardController::class, 'index']);
Route::get('/flashcards/{id}', [FlashcardController::class, 'show']);

// --- SHOP & INVENTORY ---
Route::get('/shop', [ShopController::class, 'index']);
Route::post('/shop/buy', [ShopController::class, 'buy']);
Route::post('/shop/equip', [ShopController::class, 'equip']);

// --- AUTHENTICATION ---
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout']);
