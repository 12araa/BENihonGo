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
        $user = User::with(['equippedAvatar', 'gamification'])->first();

        // 2. Logika Cerdas (Real Data with Fallback)
        $avatarPath = $user->equippedAvatar
            ? $user->equippedAvatar->asset_path
            : 'assets/avatars/headband.png';

        // Cek Gamification: Kalau belum ada data di tabel gamification, kasih nilai awal.
        $level = $user->gamification ? $user->gamification->current_level : 1;
        $gold = $user->gamification ? $user->gamification->gold : 0;
        $xp = $user->gamification ? $user->gamification->current_xp : 0; // Sesuaikan nama kolom DB nanti

        return response()->json([
            'success' => true,
            'data' => [
                // Data Asli User
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,

                // Data Game (Dinamis)
                'level' => $level,
                'xp' => $xp,
                'max_xp' => 100, // Nanti bisa dibikin rumus: $level * 100
                'gold' => $gold,

                'avatar' => asset($avatarPath)
            ]
        ]);
    }

    // 6. GET /api/histories
    public function history()
    {
        // MOCK DATA SEMENTARA
       $mockHistory = [
            [
                'id' => 101,
                'user_id' => 1,
                'stage_id' => 1,
                'is_unlocked' => true,
                'is_completed' => true,
                'best_score' => 100,

                'stage_name' => 'Grade 1: Kanji Dasar',
                'stars' => 3,
            ],
            [
                'id' => 102,
                'user_id' => 1,
                'stage_id' => 2,
                'is_unlocked' => true,
                'is_completed' => false,
                'best_score' => 45,

                // Info tambahan
                'stage_name' => 'Grade 2: Kata Benda',
                'stars' => 1,
            ]
        ];

        return response()->json([
            'success' => true,
            'data' => $mockHistory
        ]);
    }

    public function leaderboard()
    {
        $users = User::with('gamification')->get();

        // Urutkan: Siapa yang XP-nya paling tinggi dia di atas
        // Kita pakai sortByDesc dari Collection Laravel
        $sortedUsers = $users->sortByDesc(function ($user) {
            return $user->gamification ? $user->gamification->current_xp : 0;
        })->values();

        $data = $sortedUsers->map(function ($user, $index) {
            return [
                'rank' => $index + 1,
                'name' => $user->name,
                'level' => $user->gamification ? $user->gamification->current_level : 1,
                'xp' => $user->gamification ? $user->gamification->current_xp : 0,
                'avatar' => $user->equippedAvatar ? asset($user->equippedAvatar->asset_path)
                            : asset('assets/avatars/headband.png'),
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }
}
