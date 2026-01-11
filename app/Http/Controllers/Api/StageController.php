<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Stage;
use Illuminate\Http\Request;

class StageController extends Controller
{
    // 3. GET /api/stages
    public function index()
    {
        $stages = Stage::with('monster')->get();

        // Format data biar Frontend enak bacanya
        $data = $stages->map(function($stage) {
            return [
                'id' => $stage->id,
                'name' => $stage->name,
                'level_req' => $stage->level_req,
                'monster_preview' => asset($stage->monster->asset_path),
                'status' => 'unlocked', // MOCK: Ceritanya kebuka semua dulu
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    // 4. GET /api/stages/{id}
    public function show($id)
    {
        $stage = Stage::with('monster')->find($id);

        if (!$stage) return response()->json(['message' => 'Not found'], 404);

        return response()->json([
            'success' => true,
            'data' => [
                'name' => $stage->name,
                'desc' => 'Stage ini melatih Kanji dasar.', // Bisa ditambah kolom desc di DB nanti
                'monster_name' => $stage->monster->name,
                'rewards' => [
                    'exp' => $stage->monster->exp_reward,
                    'gold' => $stage->monster->gold_reward
                ]
            ]
        ]);
    }
}
