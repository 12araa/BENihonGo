<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Stage;
use App\Models\Quiz;
use App\Services\GameService;

class GameController extends Controller
{
    protected $gameService;

    public function __construct(GameService $gameService)
    {
        $this->gameService = $gameService;
    }

    public function startGame($id)
    {
        $user = Auth::user();
        if ($user->gamification->tickets < 1) {
            return response()->json([
                'success' => false,
                'message' => 'Tiket habis! Silakan belajar (Pomodoro) dulu.'
            ], 403);
        }

        $stage = Stage::with(['monster', 'chapter'])->find($id);

        if (!$stage) {
            return response()->json(['success' => false, 'message' => 'Stage tidak ditemukan'], 404);
        }

        $user->gamification->decrement('tickets');
        $quizzes = Quiz::where('stage_id', $id)
                    ->inRandomOrder()
                    ->take(10)
                    ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'stage' => $stage,
                'quizzes' => $quizzes,
                'remaining_tickets' => $user->gamification->tickets
            ]
        ]);
    }

    public function finishGame(Request $request)
    {
        $request->validate([
            'stage_id' => 'required|exists:stages,id',
            'score' => 'required|integer',
            'is_completed' => 'required|boolean',
        ]);

        try {
            $result = $this->gameService->processGameResult(
                Auth::user(),
                $request->stage_id,
                $request->score,
                $request->boolean('is_completed')
            );

            return response()->json([
                'success' => true,
                'message' => 'Game selesai!',
                'data' => $result
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
