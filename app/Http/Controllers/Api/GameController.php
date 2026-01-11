<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Flashcard;
use App\Models\Stage;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function startGame($stage_id)
    {
        $stage = Stage::with('monster')->find($stage_id);

        if (!$stage) {
            return response()->json(['message' => 'Stage not found'], 404);
        }

        // Ambil 5 soal acak
        $flashcards = Flashcard::inRandomOrder()->limit(5)->get();

        // Format Soal
        $questions = $flashcards->map(function($card) {
            return [
                'id' => $card->id,
                'type' => 'flashcard',
                'question' => $card->kanji,
                'correct_answer' => $card->meaning,
                // Mocking options (Nanti bisa dibikin lebih pintar)
                'options' => [
                    $card->meaning,
                    'Kuda',
                    'Mobil',
                    'Pesawat'
                ]
            ];
        });

        return response()->json([
            'success' => true,
            'data' => [
                'stage_info' => [
                    'id' => $stage->id,
                    'name' => $stage->name,
                    'level_req' => $stage->level_req,
                    'monster' => [
                        'name' => $stage->monster->name,
                        'hp' => $stage->monster->base_hp,
                        // Perbaikan: Pakai asset_path & damage_per_hit sesuai migration kamu
                        'damage' => $stage->monster->damage_per_hit,
                        'image' => asset($stage->monster->asset_path),
                    ]
                ],
                'questions' => $questions
            ]
        ]);
    }

    // 2. POST /api/game/finish (MOCK)
    public function finishGame(Request $request)
    {
        // Frontend kirim: { "stage_id": 1, "score": 100, "is_win": true }

        // Kita anggap user selalu dapat reward segini dulu
        return response()->json([
            'success' => true,
            'message' => 'Game finished!',
            'data' => [
                'xp_earned' => 50,
                'gold_earned' => 20,
                'is_level_up' => false, // Pura-pura belum naik level
            ]
        ]);
    }
}
