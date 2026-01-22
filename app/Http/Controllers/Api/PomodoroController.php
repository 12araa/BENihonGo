<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\PomodoroService;
use Illuminate\Support\Facades\Auth;

class PomodoroController extends Controller
{
    protected $pomodoroService;
    public function __construct(PomodoroService $pomodoroService)
    {
        $this->pomodoroService = $pomodoroService;
    }

    public function start()
    {
        $user = Auth::user();
        $log = $this->pomodoroService->startSession($user);

        return response()->json([
            'success' => true,
            'message' => 'Timer Pomodoro dimulai!',
            'data' => $log
        ]);
    }

    public function stop(Request $request)
    {
        $request->validate([
            'status' => 'required|in:completed,interrupted'
        ]);

        try {
            $user = Auth::user();
            $result = $this->pomodoroService->stopSession($user, $request->status);

            return response()->json([
                'success' => true,
                'message' => 'Sesi Pomodoro berakhir.',
                'data' => $result
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
