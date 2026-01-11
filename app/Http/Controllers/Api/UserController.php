<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function me()
    {
        // MOCK: Kita ambil user pertama aja (Tanaka)
        $user = User::first();

        return response()->json([
            'success' => true,
            'data' => [
                'name' => $user->name,
                'username' => $user->username,
                'level' => 1,       // Hardcode dulu krn tabel gamification belum di-seed
                'xp' => 0,          // Hardcode dulu
                'max_xp' => 100,
                'gold' => 500,      // Hardcode dulu
                'avatar' => asset('assets/avatars/headband.png') // Hardcode dulu
            ]
        ]);
    }

    // 6. GET /api/histories
    public function history()
    {
        // Ambil dari tabel quizzes (yang kamu pake buat history dummy)
        // Pastikan QuizSeeder sudah dijalankan
        $history = Quiz::with('stage')->orderBy('created_at', 'desc')->get();

        return response()->json([
            'success' => true,
            'data' => $history
        ]);
    }
}
